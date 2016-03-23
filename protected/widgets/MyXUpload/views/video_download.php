<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    {% if (file.error) { %}
        <div class="add-element template-download" id="deal_video_{%=file.video_id%}">
            <div class="row">
                <div class="col-lg-3">
                    <div class="image-wrap">
                        {% if (file.thumbnail_url) { %}
                            <a href="/js/uppod.swf?file={%=file.url%}" title="{%=file.name%}" class="thumbnail fancybox-video deal-video-thumb img" download="{%=file.name%}">
                                <img src="{%=file.thumbnail_url%}" alt="" />
                            </a>
                        {% } %}
                    </div>
                </div>
                <div class="element-info col-lg-6">
                    <p class="name"><span>{%=file.name%}</span></p>
                    <p class="size"><span>{%=o.formatFileSize(file.size)%}</span></p>
                    <p class="text-danger"><span class="label label-danger">{%=translate("core", "Error")%}</span> {%=translate("dealsModule", file.error)%}</p>
                </div>
                <div class="col-lg-3">
                </div>
            </div>
        </div>
    {% } else { %}
        <div class="add-element template-download" id="deal_video_{%=file.video_id%}">
            <div class="row">
                <div class="col-lg-3">
                    <div class="image-wrap">
                        <label class="checkbox">
                            <input type="checkbox" name="delete" value="1">
                            <span class="a-spr"></span>
                        </label>
                        {% if (file.thumbnail_url) { %}
                            <a href="/js/uppod.swf?file={%=file.url%}" title="{%=file.name%}" class="thumbnail fancybox-video deal-video-thumb img" download="{%=file.name%}">
                                <img src="{%=file.thumbnail_url%}" alt="" />
                            </a>
                        {% } %}
                    </div>
                </div>
                <div class="element-info col-lg-6">
                    <div class="form-group">
                        <label for="edit_video_alias_textfield_{%=file.video_id%}">{%=translate("dealsModule", "Video name")%}</label>
                        <input type="text" value="{%=file.alias%}" class="edit-video-alias-textfield" id="edit_video_alias_textfield_{%=file.video_id%}"/>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <div class="form-group">
                        <label for="video_desc_textarea_{%=file.video_id%}">{%=translate("dealsModule", "Video description")%}</label>
                        <textarea class="form-control edit-video-desc-textarea" placeholder="{%=translate("dealsModule", "Enter comment")%}" id="edit_video_desc_textarea_{%=file.video_id%}" rows="3"></textarea>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <!--div class="size">{%=o.formatFileSize(file.size)%}</div-->
                </div>
                <div class="col-lg-3">
                    <a href="" class="delete btn btn-danger delete-video" data-video="{%=file.video_id%}">{%=translate("core", "Delete")%}</a>
                </div>
            </div>
        </div>
    {% } %}
{% } %}
</script>

