<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="add-element template-upload" id="deal_video_{%=file.video_id%}">
        <div class="row">
            {% if (file.error) { %}
                <div class="col-lg-3">
                    <div class="image-wrap">
                        <div class="preview"><span></span></div>
                    </div>
                </div>
                <div class="element-info col-lg-6">
                    <p class="name"><span>{%=file.name%}</span></p>
                    <p class="size"><span>{%=o.formatFileSize(file.size)%}</span></p>
                    <p class="text-danger"><span class="label label-danger">{%=translate("core", "Error")%}</span> {%=translate("dealsModule", file.error)%}</p>
                </div>
                <div class="col-lg-3 cancel">
                    <button class="btn btn-danger delete">
                        <i class="icon-ban-circle icon-white"></i>
                        <span>{%=translate("core", "Cancel")%}</span>
                    </button>
                </div>

            {% } else if (o.files.valid && !i) { %}
                <div class="col-lg-3">
                    <div class="image-wrap">
                        <div class="preview"><span></span></div>
                    </div>
                </div>
                <div class="element-info col-lg-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_video_alias_textfield_{%=file.video_id%}">{%=translate("dealsModule", "Video name")%}</label>
                        <input type="text" value="{%=file.alias%}" class="edit-video-alias-textfield" id="edit_video_alias_textfield_{%=file.video_id%}" disable="disabled"/>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <div class="form-group">
                        <label for="video_desc_textarea_{%=file.video_id%}">{%=translate("dealsModule", "Video description")%}</label>
                        <textarea class="form-control edit-video-desc-textarea" placeholder="{%=translate("dealsModule", "Enter comment")%}" id="edit_video_desc_textarea_{%=file.video_id%}" rows="3" disable="disabled"></textarea>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <!--div class="size">{%=o.formatFileSize(file.size)%}</div-->
                </div>
                <div class="col-lg-3 cancel">
                    <button class="btn btn-danger delete">
                        <i class="icon-ban-circle icon-white"></i>
                        <span>{%=translate("core", "Cancel")%}</span>
                    </button>
                </div>
            {% } else { %}
                <div class="col-lg-12">
                    <p class="error">{%=translate("core", "Undefined error!")%}</p>
                </div>
            {% } %}
        </div>
    </div>
{% } %}
</script>
