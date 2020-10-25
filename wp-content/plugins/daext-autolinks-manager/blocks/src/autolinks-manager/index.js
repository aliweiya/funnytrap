import './editor.css';

const {__} = wp.i18n;
const {registerPlugin} = wp.plugins;
const {PluginSidebar} = wp.editPost;
const {SelectControl} = wp.components;
const {withSelect, withDispatch} = wp.data;
const {Component} = wp.element;

class Autolinks_Manager extends Component {

  constructor(){

    super(...arguments);

    /**
     * If the '_daam_enable_autolinks' meta of this post is not defined get its value from the plugin options from a
     * custom endpoint of the WordPress Rest API.
     */
    if(wp.data.select('core/editor').getEditedPostAttribute('meta')['_daam_enable_autolinks'].length === 0){

      wp.apiFetch( { path: '/daext-autolinks-manager/v1/options', method: 'GET' } ).then(
          ( data ) => {

            wp.data.dispatch( 'core/editor' ).editPost(
                { meta: { _daam_enable_autolinks: data.daam_advanced_enable_autolinks } }
            );

          },
          ( err ) => {

            return err;

          }
      );

    }

  }

  render() {

    const MetaBlockField = function(props) {
      return (
          <SelectControl
              label={__('Enable Autolinks', 'daam')}
              value={props.metaFieldValue}
              options={[
                {value: '0', label: __('No', 'daam')},
                {value: '1', label: __('Yes', 'daam')},
              ]}
              onChange={function(content) {
                props.setMetaFieldValue(content);
              }}
          >
          </SelectControl>
      );
    };

    const MetaBlockFieldWithData = withSelect(function(select) {
      return {
        metaFieldValue: select('core/editor').getEditedPostAttribute('meta')
            ['_daam_enable_autolinks'],
      };
    })(MetaBlockField);

    const MetaBlockFieldWithDataAndActions = withDispatch(
        function(dispatch) {
          return {
            setMetaFieldValue: function(value) {
              dispatch('core/editor').editPost(
                  {meta: {_daam_enable_autolinks: value}},
              );
            },
          };
        },
    )(MetaBlockFieldWithData);

    return (
        <PluginSidebar
            name='autolinks-manager-sidebar'
            icon='admin-links'
            title={__('Autolinks Manager', 'daam')}
        >
          <div
              className='autolinks-manager-sidebar-content'
          >
            <MetaBlockFieldWithDataAndActions></MetaBlockFieldWithDataAndActions>
          </div>
        </PluginSidebar>
    );

  }

}

registerPlugin('daam-autolinks-manager', {
  render: Autolinks_Manager,
});