const{Component}=wp.element;const{TextControl,Button,Tooltip}=wp.components;if(typeof wp.blockEditor!=='undefined')
var{InspectorControls,InspectorAdvancedControls}=wp.blockEditor;else
var{InspectorControls,InspectorAdvancedControls}=wp.editor;import{RevSliderImage}from './revSliderImage';export class RevSlider extends Component{constructor(){super(...arguments);this.state=jQuery.extend(true,{},this.props.attributes);window.revslider_react={};}
componentDidMount(){revslider_react=this;RVS.SC.BLOCK=this.state;if(!this.props.attributes.content&&!this.props.attributes.text){if(wp.data.select('core/editor')!=null&&wp.data.select('core/editor').isEditedPostDirty())RVS.SC.openTemplateLibrary('gutenberg');else return false;}
else{if(!this.props.attributes.alias){let shortcode=this.props.attributes.content!==undefined?RVS.SC.parseShortCode(this.props.attributes.content):RVS.SC.parseShortCode(this.props.attributes.text);if(shortcode.attributes.alias){this.props.attributes.alias=shortcode.attributes.alias;RVS.SC.BLOCK.alias=this.props.attributes.alias;this.props.setAttributes({alias:shortcode.attributes.alias});}}
if(!this.props.attributes.slidertitle){if(this.props.attributes.sliderTitle){this.props.setAttributes({slidertitle:this.props.attributes.sliderTitle});}}}}
openBlockSettings=()=>{var data=false;RVS.SC.BLOCK=this.state;revslider_react=this;if(!this.props.attributes.alias)return false;RVS.SC.openBlockSettings('gutenberg',this.props.attributes.content);};openLibrary=()=>{revslider_react=this;RVS.SC.BLOCK=this.props.attributes;RVS.SC.openTemplateLibrary('gutenberg');}
openSliderEditor=()=>{if(!this.props.attributes.alias)return false;RVS.SC.openSliderEditor(this.props.attributes.alias);};setwrapperid=(value)=>{revslider_react=this;this.props.setAttributes({wrapperid:value});RVS.SC.BLOCK=this.state;RVS.SC.BLOCK.wrapperid=value;}
openOptimizer=()=>{if(!this.props.attributes.alias)return false;RVS.SC.openOptimizer(this.props.attributes.alias);}
setSliderAttributes=(alias)=>{setAttributes({alias});setAttributes({sliderImage:this.state.sliderImage});}
render(){revslider_react=this;this.props.setAttributes(this.state);const{setAttributes}=this.props;{!this.props.isSelected&&(RVS.SC.updateBlockViews(false))}
if(!this.props.attributes.slidertitle){if(this.props.attributes.sliderTitle){this.props.setAttributes({slidertitle:this.props.attributes.sliderTitle});}}
return[<InspectorControls>{this.props.attributes.alias&&<div className="rs_optimizer_button_wrapper"onClick={this.openOptimizer}><Button
isDefault
className={'rs_optimizer_button'}>flash_on</Button><span>Optimize File Sizes</span></div>}</InspectorControls>,<InspectorAdvancedControls><TextControl
label="Module Wrapper IDs"
value={this.props.attributes.wrapperid}
onChange={(value)=>this.setwrapperid(value)}
help="Enter a word or two — without spaces or special characters — to make a unique web address just for this module."/></InspectorAdvancedControls>,,<div className="revslider_block"data-modal={this.props.attributes.modal}><div class="sliderBar"><span>{this.props.attributes.slidertitle}&nbsp;</span><TextControl
className="slider_slug"
value={this.props.attributes.content}
onChange={(content)=>setSliderAttributes(this.props.attributes.content)}/><Tooltip text="Open Block Settings"><Button
isDefault
onClick={this.openBlockSettings}
className="slider_editor_button">tune</Button></Tooltip><Tooltip text="Open Slider Editor"><Button
isDefault
onClick={this.openSliderEditor}
className="slider_editor_button">edit</Button></Tooltip><Button
isDefault
onClick={this.openLibrary}
className="slider_edit_button">Select Module</Button></div><RevSliderImage{...{setAttributes,...this.props}}/></div>]}}