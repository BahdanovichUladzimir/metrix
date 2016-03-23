<!-- The template to display files available for download -->
<script>
    $(document).ready(function(){
        var body = $("body");
        body.on('click','.add-image-description', function(){
            var link = $(this);
            var container = link.parent(".add-image-desc-container");
            var textarea = container.find('.add-image-desc-textarea');
            var group = container.find(".form-group");
            var image_id = textarea.attr('id').substr(20);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setImageDescription",
                type: 'post',
                data: {
                    image_id:image_id, description: description
                },
                beforeSend: function(){
                    link.addClass('loading');
                },
                success:function(json){
                    $(this).removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
                    }
                    else if(response.status == "error"){
                        group.addClass('has-error');
                        group.find('.help-block').text(response.message).show();
                    }
                    else{
                        group.addClass('has-error');
                        group.find('.help-block').text("Unknown error").show();
                    }
                }
            });
            return false;
        });
        body.on('click','.add-video-description', function(){
            var link = $(this);
            var container = link.parent(".add-video-desc-container");
            var textarea = container.find('.add-video-desc-textarea');
            var group = container.find(".form-group");
            var video_id = textarea.attr('id').substr(20);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setVideoDescription",
                type: 'post',
                data: {
                    video_id:video_id, description: description
                },
                beforeSend: function(){
                    link.addClass('loading');
                },
                success:function(json){
                    link.removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
                    }
                    else if(response.status == "error"){
                        group.addClass('has-error');
                        group.find('.help-block').text(response.message).show();
                    }
                    else{
                        group.addClass('has-error');
                        group.find('.help-block').text("Unknown error").show();
                    }
                }
            });
            return false;
        })
    })
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                {% if (file.file_type == 'image') { %}
                    <div class="add-image-desc-container" id="add_image_desc_container_{%=file.image_id%}">
                        <div class="form-group">
                            <label for="image_desc_textarea_{%=file.image_id%}">Image description</label>
                            <textarea class="form-control add-image-desc-textarea" placeholder="Enter comment" id="image_desc_textarea_{%=file.image_id%}" rows="3"></textarea>
                            <span class="help-block" style="display:none"></span>
                        </div>
                        <a class="btn btn-success add-image-description" href="">Save</a>
                    </div>
                {% } else if (file.file_type == 'video') { %}
                    <div class="add-video-desc-container" id="add_video_desc_container_{%=file.video_id%}">
                        <div class="form-group">
                            <label for="video_desc_textarea_{%=file.video_id%}">Video description</label>
                            <textarea class="form-control add-video-desc-textarea" placeholder="Enter comment" id="video_desc_textarea_{%=file.video_id%}" rows="3"></textarea>
                        </div>
                        <a class="btn btn-success add-video-description" href="">Save</a>
                    </div>
                {% } else { %}
                {% } %}
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <?php if ($this->multiple) : ?><input type="checkbox" name="delete" value="1">
            <?php else: ?><input type="hidden" name="delete" value="1">
            <?php endif; ?>
        </td>
    </tr>
{% } %}
</script>
