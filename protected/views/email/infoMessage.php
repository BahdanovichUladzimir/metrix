<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 01.02.2016
 * @var User $user
 * @var int $sizeOfMessages
 */
;?>
Уважаемый <?=$user->username;?>!<br>
У Вас имеется <?=$sizeOfMessages;?> непрочитанныx сообщений на сайте all4holidays.com!<br>
Для просмотра сообщений перейдите по ссылке:<br>
<a href="https://all4holidays.com/messages/user/dialogues/index#main_menu_container">Сообщения</a><br>
Что-бы отписаться перейдите по ссылке: <br>
<a href="https://all4holidays.com/site/unsubscribe?user_id=<?=$user->id;?>&activkey=<?=$user->activkey;?>">Отписаться от рассылки</a><br>

