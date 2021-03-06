<?php if (count($chats) > 0) { ?>
<ul class="no-bullet">
	<?php foreach ($chats as $chat) : ?>
	      <li class="chat-row-<?php echo $chat['id'];?>">
	      <?php if ( !empty($chat['country_code']) ) : ?><img src="<?php echo erLhcoreClassDesign::design('images/flags');?>/<?php echo $chat['country_code']?>.png" alt="<?php echo htmlspecialchars($chat['country_name'])?>" title="<?php echo htmlspecialchars($chat['country_name'])?>" />&nbsp;<?php endif; ?>    		      
	      <?php if ($right === false) : ?><img class="action-image" align="absmiddle" onclick="lhinst.startChat('<?php echo $chat['id'];?>',$('#tabs'),'<?php echo htmlspecialchars($chat['nick']);?>')" src="<?php echo erLhcoreClassDesign::design('images/icons/add.png');?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Add chat');?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Add chat');?>"><?php endif; ?>
	      <img class="action-image" align="absmiddle" onclick="lhinst.startChatNewWindow('<?php echo $chat['id'];?>','<?php echo htmlspecialchars($chat['nick']);?>')" src="<?php echo erLhcoreClassDesign::design('images/icons/application_add.png');?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in new window');?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in new window');?>">
	      <img class="action-image" align="absmiddle" onclick="lhinst.closeActiveChatDialog('<?php echo $chat['id'];?>',$('#tabs'),false)" src="<?php echo erLhcoreClassDesign::design('images/icons/cancel.png');?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Close chat');?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Close chat');?>">
	      <img class="action-image" align="absmiddle" onclick="lhinst.deleteChat('<?php echo $chat['id'];?>',$('#tabs'))" src="<?php echo erLhcoreClassDesign::design('images/icons/delete.png');?>" alt="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Delete chat');?>" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Delete chat');?>"> <?php echo $chat['id'];?>. <?php echo htmlspecialchars($chat['nick']);?> (<?php echo date('Y-m-d H:i:s',$chat['time']);?>) (<?php echo htmlspecialchars($chat['name']);?>)
	      </li>
	<?php endforeach; ?>
</ul>
<?php } else { ?>
<p>
<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Empty...');?>
</p>
<?php } ?>