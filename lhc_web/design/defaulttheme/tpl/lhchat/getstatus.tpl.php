<?php $isOnlineHelp = erLhcoreClassChat::isOnline(); 

// Perhaps user do not want to show live help then it's offline
if ( !($isOnlineHelp == false && $hide_offline == 'true') ) : ?>

var lh_inst  = {

    urlopen : "<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/startchat')?>",

    windowname : "startchatwindow",

    addCss : function(css_content) {
        var head = document.getElementsByTagName('head')[0];
        var style = document.createElement('style');
        style.type = 'text/css';
        
        if(style.styleSheet) {
          style.styleSheet.cssText = css_content;
        } else {
          rules = document.createTextNode(css_content);
          style.appendChild(rules);
        };
        
        head.appendChild(style);
    },
    
    appendHTML : function (htmlStr) {
        var frag = document.createDocumentFragment(),
            temp = document.createElement('div');
        temp.innerHTML = htmlStr;
        while (temp.firstChild) {
            frag.appendChild(temp.firstChild);
        };
        return frag;
    },

    removeById : function(EId)
    {
        return(EObj=document.getElementById(EId))?EObj.parentNode.removeChild(EObj):false;
    },

    hide : function() {
        var th = document.getElementsByTagName('head')[0];
        var s = document.createElement('script');
        s.setAttribute('type','text/javascript');
        s.setAttribute('src','<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatwidgetclosed')?>');
        th.appendChild(s);
        this.removeById('lhc_container');
        <?php if ($check_operator_messages == 'true') : ?>
        this.startNewMessageCheck();
        <?php endif; ?>
    },
    
    openRemoteWindow : function() {
        this.removeById('lhc_container');
        window.open(this.urlopen+'?URLReferer='+escape(document.location),this.windowname,"menubar=1,resizable=1,width=500,height=520");
    },

    showStartWindow : function(url_to_open) {

          this.removeById('lhc_container');

          if ( url_to_open != undefined ) {
                this.initial_iframe_url = url_to_open+'?URLReferer='+escape(document.location);
          } else {
                this.initial_iframe_url = "<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatwidget')?>"+'?URLReferer='+escape(document.location);
          }

          this.iframe_html = '<iframe id="fdbk_iframe" allowTransparency="true" scrolling="no" class="loading" frameborder="0" ' +
                       ( this.initial_iframe_url != '' ? ' src="'    + this.initial_iframe_url + '"' : '' ) +
                       ' width="300"' +
                       ' height="320"' +
                       ' style="width: 300px; height: 340px;"></iframe>';

          this.iframe_html = '<div id="lhc_container">' +
                              '<div id="lhc_header"><span id="lhc_title"><a title="Powered by Live Helper Chat" href="http://livehelperchat.com" target="_blank"><img src="<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/lhc.png');?>" alt="Live Helper Chat" /></a></span><a href="#" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Close")?>" id="lhc_close"><img src="<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/cancel.png');?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Close")?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Close")?>" /></a>&nbsp;<a href="#" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Open in a new window")?>" id="lhc_remote_window"><img src="<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/application_double.png');?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Open in a new window")?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Open in a new window")?>" /></a></div>' +
                              this.iframe_html + '</div>';

          raw_css = "#lhc_container * {font-family:arial;font-size:12px;box-sizing: content-box;-moz-box-sizing:content-box;}\n#lhc_container img {border:0;}\n#lhc_title{float:left;}\n#lhc_header{position:relative;z-index:9999;height:15px;overflow:hidden;-webkit-border-top-left-radius: 10px;-moz-border-radius-topleft: 10px;border-top-left-radius: 10px;background-color:#FFF;text-align:right;clear:both;border-bottom:1px solid #CCC;padding:5px;}\n#lhc_remote_window,#lhc_close{padding:2px;float:right;}\n#lhc_close:hover,#lhc_remote_window:hover{background:#e5e5e5;}\n#lhc_container {\;width:300px;\nz-index:9999;\n  height: 365px;\n position: fixed;bottom:0;right:0;-webkit-box-shadow: -2px -2px 5px rgba(50, 50, 50, 0.17);-moz-box-shadow:    -2px -2px 5px rgba(50, 50, 50, 0.17);box-shadow:         -2px -2px 5px rgba(50, 50, 50, 0.17);border:1px solid #CCC;-webkit-border-top-left-radius: 10px;-moz-border-radius-topleft: 10px;border-top-left-radius: 10px; }\n#lhc_container iframe.loading{\nbackground: #FFF url(<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/general/loading.gif');?>) no-repeat center center; }\n";
          this.addCss(raw_css);

          var fragment = this.appendHTML(this.iframe_html);

          document.body.insertBefore(fragment, document.body.childNodes[0]);  

          var lhc_obj = this;
          document.getElementById('lhc_close').onclick = function() { lhc_obj.hide(); return false; };
          document.getElementById('lhc_remote_window').onclick = function() { lhc_obj.openRemoteWindow(); return false; };

          // Do not check for new messages
          this.stopCheckNewMessage();
    },    
    
    lh_openchatWindow : function() {
        <?php if ($click == 'internal') : ?>
        this.showStartWindow();
        <?php else : ?>
        window.open(this.urlopen+'?URLReferer='+escape(document.location),this.windowname,"menubar=1,resizable=1,width=500,height=520");	      
        <?php endif; ?>
        return false;
    },

    showStatusWidget : function() {

        var statusTEXT = '<a id="<?php ($isOnlineHelp == true) ? print 'online-icon' : print 'offline-icon' ?>" class="status-icon" href="#" onclick="return lh_inst.lh_openchatWindow()" ><?php if ($isOnlineHelp == true) : ?><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Live help is online...")?><?php else : ?><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Live help is offline...")?><?php endif;?></a>';

        var raw_css = "#lhc_status_container * {font-family:arial;font-size:12px;box-sizing: content-box;zoom:1;}\n#lhc_status_container .status-icon{text-decoration:none;font-size:12px;font-weight:bold;color:#000;display:block;padding:9px 10px 9px 35px;background:url('<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/user_green_chat.png');?>') no-repeat center left}\n#lhc_status_container #offline-icon{background-image:url('<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/user_gray_chat.png');?>')}\n#lhc_status_container{-webkit-box-shadow: -2px -2px 5px rgba(50, 50, 50, 0.17);-moz-box-shadow:    -2px -2px 5px rgba(50, 50, 50, 0.17);box-shadow:         -2px -2px 5px rgba(50, 50, 50, 0.17);border-top:1px solid #e3e3e3;border-left:1px solid #e3e3e3;-webkit-border-top-left-radius: 20px;-moz-border-radius-topleft: 20px;border-top-left-radius: 20px;padding:5px 0px 0px 5px;width:190px;font-family:arial;font-size:12px;position:fixed;bottom:0;right:0;background-color:#f6f6f6;z-index:9998;}\n";
        this.addCss(raw_css);

        var htmlStatus = '<div id="lhc_status_container">'+statusTEXT+'</div>';

        var fragment = this.appendHTML(htmlStatus);

        document.body.insertBefore(fragment, document.body.childNodes[0]);
    },
    
    timeoutInstance : null,
    
    stopCheckNewMessage : function() {
        clearTimeout(timeoutInstance);
    },
    
    startNewMessageCheck : function() {
        timeoutInstance = setTimeout(function() {        
            lh_inst.removeById('lhc_operator_message');                   
            var th = document.getElementsByTagName('head')[0];
            var s = document.createElement('script');
            s.setAttribute('id','lhc_operator_message');
            s.setAttribute('type','text/javascript');
            s.setAttribute('src','<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/chatcheckoperatormessage')?>');
            th.appendChild(s);
            lh_inst.startNewMessageCheck();
        }, <?php echo (int)(erConfigClassLhConfig::getInstance()->getSetting('chat','check_for_operator_msg')*1000) ?> );
    }
};

<?php if ($check_operator_messages == 'true') : ?>
lh_inst.startNewMessageCheck();
<?php endif; ?>

<?php if ($position == 'original' || $position == '') : 
// You can style bottom HTML whatever you want. ?>
document.getElementById('lhc_status_container').innerHTML = '<p><a href="#" onclick="return lh_inst.lh_openchatWindow()"><?php if ($isOnlineHelp == true) : ?><img src="<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/user_green_chat.png');?>" alt="" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Live help is online...")?><?php else : ?><img src="<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::design('images/icons/user_gray_chat.png');?>" alt="" /><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/getstatus',"Live help is offline...")?><?php endif;?></a></p>';
<?php elseif ($position == 'bottom_right') : ?>
lh_inst.showStatusWidget();
<?php endif; 

// User has pending chat
if (($hashSession = CSCacheAPC::getMem()->getSession('chat_hash_widget')) !== false) : ?>
   lh_inst.stopCheckNewMessage();
   lh_inst.showStartWindow();
<?php elseif (isset($visitor) && $visitor->has_message_from_operator == true) : ?>
   lh_inst.stopCheckNewMessage();
   lh_inst.showStartWindow('<?php echo erLhcoreClassSystem::instance()->baseHTTP?><?php echo $_SERVER['HTTP_HOST']?><?php echo erLhcoreClassDesign::baseurl('chat/readoperatormessage')?>');
<?php endif;

endif; // hide if offline

exit; ?>