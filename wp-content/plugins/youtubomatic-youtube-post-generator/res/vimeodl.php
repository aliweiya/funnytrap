<?php
if(!class_exists('VideoControllerDownloaderLoader'))
{
    class VideoControllerDownloaderLoader
    {
        /**
         * @var array Vimeo video quality priority
         */
        public $vimeoQualityPrioritet = array('1080p', '720p', '540p', '360p');
        /**
         * Get direct URL to Vimeo video file
         *
         * @param string $url to video on Vimeo
         * @return string file URL
         */
        public function getVimeoDirectUrl($url)
        {
            $result = '';
            $videoInfo = $this->getVimeoVideoInfo($url);
            if ($videoInfo && $videoObject = $this->getVimeoQualityVideo($videoInfo->request->files))
            {
                $result = $videoObject->url;
            }
            return $result;
        }
        /**
         * Get Vimeo Player ,Video config object
         *
         */
        function getConfigObjectFromHtml($string, $start, $end) {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        /**
         * Get Vimeo video info
         *
         * @param string $url to video on Vimeo
         * @return \stdClass|null result
         */
        public function getVimeoVideoInfo($url)
        {
            $videoInfo = null;
            $page = $this->getRemoteContent($url);
            $html = $this->getConfigObjectFromHtml($page, 'clip_page_config =', '// Autoplay test');
            $json = chop(trim($html), ';');
            $videoConfig = json_decode($json);
            if (isset($videoConfig->player->config_url))
            {
                $videoObj = json_decode($this->getRemoteContent($videoConfig->player->config_url));
                if (!property_exists($videoObj, 'message'))
                {
                    $videoInfo = $videoObj;
                }
            }
            return $videoInfo;
        }
        /**
         * Get vimeo video object
         *
         * @param stdClass $files object of Vimeo files
         * @return stdClass Video file object
         */
        public function getVimeoQualityVideo($files)
        {
            $video = null;
            if (count($files->progressive))
            {
                $this->vimeoVideoQuality = $files->progressive;
            }
            foreach ($this->vimeoQualityPrioritet as $k => $quality)
            {
                if ($this->vimeoVideoQuality[$k]->quality == $quality)
                {
                    $video = $this->vimeoVideoQuality[$k];
                    break;
                }
            }
            if (!$video)
            {
                if(!is_array($this->vimeoVideoQuality))
                {
                    $this->vimeoVideoQuality = get_object_vars($this->vimeoVideoQuality);
                }
                foreach ($this->vimeoVideoQuality as $file)
                {
                    $video = $file;
                    break;
                }
            }
            return $video;
        }
        /**
         * Get remote content by URL
         *
         * @param string $url remote page URL
         * @return string result content
         */
        function getRemoteContent($url) {
            global $wp_filesystem;
            if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                wp_filesystem($creds);
            }
            $data = $wp_filesystem->get_contents($url);
            return $data;
        }
    }
}
?>