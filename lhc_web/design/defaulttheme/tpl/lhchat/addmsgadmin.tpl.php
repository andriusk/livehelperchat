<div class="message-row"><div class="msg-date"><?=date('Y-m-d H:i:s',$msg->time);?></div><span class="usr-tit"><?=$msg->name_support?>:</span> <?=nl2br(htmlspecialchars(trim($msg->msg)));?></div>