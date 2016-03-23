<?php
/**
 * @var $receiver User
 * @var $sender User
 * @var array $dialogues
 * @var $dialog Dialogues
 * @var $dataProvider CActiveDataProvider
 */
$this->breadcrumbs=array(
    //Yii::t('messagesModule','User') => '',
    Yii::t('messagesModule','Messages'),
);?>
<script type="text/javascript">

    $(document).ready(function(){

        $("#delete_dialog_link").click(function(){
            if(confirm("<?=Yii::t("messagesModule","Are you sure?");?>")){
                var dialogId = $(this).data('dialog');
                $.ajax({
                    type: 'post',
                    url: "<?=Yii::app()->createUrl('/messages/user/dialogues/delete');?>",
                    data: {
                        'dialog_id': dialogId
                    },
                    success: function(data)
                    {
                        window.location.href = "<?=Yii::app()->createUrl('/messages/user/dialogues/index');?>";
                    },
                    error: function(){
                        alert("Error")
                    }
                });
            }
            return false;
        });
        $('.pager').hide();
        var userMessagesWrap = $('#messages-wrap');
        var messagesPane = userMessagesWrap.jScrollPane().data('jsp');

        // запоминаем текущую страницу и их максимальное количество
        var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
        var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');

        var scrollToTopHandler = function(event, scrollPositionY, isAtTop, isAtBottom){
            if(isAtTop && pageCount>1){
                userMessagesWrap.unbind('jsp-scroll-y', scrollToTopHandler);
                // отображаем анимацию загрузки
                $('#loading').show();
                $.ajax({
                    type: 'post',
                    url: window.location.href,
                    data: {
                        // передаём номер нужной страницы методом POST
                        'page': page + 1,
                        '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                    },
                    success: function(data)
                    {
                        // увеличиваем номер текущей страницы и снимаем блокировку
                        page++;

                        // прячем анимацию загрузки
                        $('#loading').hide();

                        // вставляем полученные записи после имеющихся в наш блок
                        var html = $(data);
                        var messages = html.find(".message-wrap");
                        $('#listView .items').prepend(messages);
                        messagesPane.reinitialise();
                        userMessagesWrap.bind(
                            'jsp-scroll-y',
                            scrollToTopHandler
                        );
                        // если достигли максимальной страницы, то прячем кнопку
                        if (page >= pageCount){
                            userMessagesWrap.unbind('jsp-scroll-y', scrollToTopHandler);
                        }
                    }
                });
            }
        };
        $("#add_message_link").click(function(){
            var textarea = $(this).closest("form").find("textarea");
            var text = textarea.val();
            $.ajax({
                url:"<?=Yii::app()->createUrl('/messages/user/userMessages/create');?>",
                type:'post',
                data:{
                    text:text,
                    receiver_id:<?=$receiver->id;?>
                },
                success:function(json){
                    var data = $.parseJSON(json);
                    if(data.status == 'success'){
                        userMessagesWrap.unbind('jsp-scroll-y',scrollToTopHandler);
                        var messagesContainer = $('#messages-wrap .jspPane .items');
                        var messages = messagesContainer.children();
                        if(pageCount>1){
                            messages.first().remove();
                        }
                        messagesContainer.append(data.html);

                        messagesPane.reinitialise();
                        messagesPane.scrollToBottom();

                        $(window).trigger('messagesModule.createMessage.success',{message_id:data.message_id});
                        userMessagesWrap.bind('jsp-scroll-y',scrollToTopHandler);
                        textarea.val("");
                    }
                    else if(data.status == 'error'){
                        textarea.next('.text-danger').text(data.message).show();
                    }
                }
            });
            return false;
        });
        userMessagesWrap.jScrollPane();



        var first_unread_message = $(".unread-message.receiver-message").first();
        if(first_unread_message.length>0){
            messagesPane.scrollToElement(first_unread_message, true);
            readMessages();
            userMessagesWrap.bind(
                'jsp-scroll-y',
                function(event, scrollPositionY, isAtTop, isAtBottom)
                {
                    readMessages();
                }
            )
        }
        else{
            messagesPane.scrollToBottom();
        }
        userMessagesWrap.bind(
            'jsp-scroll-y',
            scrollToTopHandler
        );


        $("body").on("click", ".delete-message-link", function(){
            if(confirm("<?=Yii::t("messagesModule","Are you sure?");?>")){
                var message = $(this).closest(".message-wrap");
                var message_id = $(this).data('message');
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/messages/user/userMessages/delete');?>",
                    type:'post',
                    data:{
                        message_id:message_id
                    },
                    success:function(json){
                        var data = $.parseJSON(json);
                        if(data.status == 'success'){
                            $(window).trigger('messagesModule.deleteMessage.success',{message_id:data.message_id});
                            message.remove();
                        }
                        else if(data.status == 'error'){
                            $(window).trigger('messagesModule.deleteMessage.error',{message_id:data.message_id});
                        }
                    },
                    error:function(){
                        console.log('Undefined error!');
                    }
                });
            }
        });
    });
    function readMessages(){
        var userMessagesWrap = $('#messages-wrap');
        var unreadMessages = $('.receiver-message.unread-message');
        if(unreadMessages.length>0){
            unreadMessages.each(function(){
                var message = $(this);
                var messageId = $(this).attr('id').substr(13);
                var w = $(window);
                var offset = message.offset();
                var messageBottomPosition = offset.top-w.scrollTop()+$(this).outerHeight();
                var wrapperBottomPosition = userMessagesWrap.offset().top-w.scrollTop()+userMessagesWrap.height();
                //@todo Заменить цифру на параметр, брать из стиля элемента
                if(messageBottomPosition-19<=wrapperBottomPosition){
                    message.removeClass("unread-message").addClass("send-to-set-read-message");
                    $.ajax({
                        url:"<?=Yii::app()->createUrl("/messages/user/userMessages/read");?>",
                        type:'post',
                        data:{message_id:messageId},
                        success:function(json){
                            var data = $.parseJSON(json);
                            if(data.status == 'success'){
                                message.removeClass("send-to-set-read-message").addClass("read-message");
                                $(window).trigger('messagesModule.readMessage.success',{message_id:data.message_id, dialog_id:data.dialog_id});
                            }
                            else if(data.status == 'error'){
                                $(window).trigger('messagesModule.readMessage.error',{message_id:data.message_id, dialog_id:data.dialog_id});
                            }
                        }
                    });
                }
            });
        }
    }
</script>

<section>
    <div class="row">
        <div class="col-lg-3 col-lg-offset-1">
            <?php $this->renderPartial('_dialogues_list', array('dialogues' => $dialogues)); ?>
        </div>
        <div class="col-lg-7">
            <div class="panel">
                <div class="panel-body">
                    <?php if(isset($dialog)):?>
                        <div class="edit-wrap settings">
                            <a href="#" class="edit b-spr"></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="#"><?/*=Yii::t("messagesModule","Block dialog");*/?></a></li>
                                <li><a href="#"><?/*=Yii::t("messagesModule","It's spam");*/?></a></li>-->

                                <li><a href="" class="delete" id="delete_dialog_link" data-dialog="<?=$dialog->id;?>"><?=Yii::t("messagesModule","Remove dialog");?></a></li>
                            </ul>
                        </div>
                    <?php endif;?>

                    <h5 class="title border h5"><?=Yii::t("messagesModule","Dialog with");?> <a href="<?=$receiver->getPublicUrl();?>"><?=$receiver->username;?></a></h5>
                    <div class="scroll-wrap">
                        <div class="scroll-pane" id="messages-wrap">
                            <?php $this->renderPartial(
                                '_loop',
                                array(
                                    'dataProvider'=>$dataProvider,
                                    'receiver'=>$receiver
                                )
                            ); ?>
                        </div>
                    </div>
                    <div class="send-mess-form message-wrap">
                        <img src="<?=$sender->getSmallAvatar();?>" alt="<?=$sender->username;?>" />
                        <div class="message">
                            <form>
                                <textarea class="has-error" placeholder="<?=Yii::t('messagesModule',"Enter text");?>"></textarea>
                                <span class="text-danger" style="display: block"></span>
                                <div class="ta-r">
                                    <?php //<a href="#" class="add"></a> ;?>
                                    <a href="#" class="btn btn-blue" id="add_message_link"><?=Yii::t('core',"Send");?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>