<!-- The template to display files available for download -->

<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    {% if (file.error) { %}
        <div class="add-element template-download" id="deal_image_{%=file.image_id%}">
            <div class="row">
                <div class="col-lg-3">
                    <div class="image-wrap">
                        <label class="checkbox">
                            <input type="checkbox" name="delete" value="1" data-image_id="{%=file.image_id%}">
                            <span class="a-spr"></span>
                        </label>
                        {% if (file.thumbnail_url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" class="thumbnail fancybox deal-image-thumb img" download="{%=file.name%}">
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
                    <a href="" class="delete btn btn-danger delete-image" data-image="{%=file.image_id%}">{%=translate("core", "Delete")%}</a>
                </div>
            </div>
        </div>
    {% } else { %}
        <div class="add-element template-download" id="deal_image_{%=file.image_id%}">
            <div class="row">
                <div class="col-lg-3">
                    <div class="image-wrap">
                        <label class="checkbox">
                            <input type="checkbox" name="delete" value="1" data-image_id="{%=file.image_id%}">
                            <span class="a-spr"></span>
                        </label>
                        {% if (file.thumbnail_url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" class="thumbnail fancybox deal-image-thumb img" download="{%=file.name%}">
                                <img src="{%=file.thumbnail_url%}" alt="" />
                            </a>
                        {% } %}
                    </div>
                </div>
                <div class="element-info col-lg-6">
                    <div class="form-group">
                        <label for="edit_image_alias_textfield_{%=file.image_id%}">{%=translate("dealsModule", "Image name")%}</label>
                        <input type="text" value="{%=file.alias%}" class="edit-image-alias-textfield" id="edit_image_alias_textfield_{%=file.image_id%}"/>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <div class="form-group">
                        <label for="image_desc_textarea_{%=file.image_id%}">{%=translate("dealsModule", "Image description")%}</label>
                        <textarea class="form-control edit-image-desc-textarea" placeholder="{%=translate("dealsModule", "Enter comment")%}" id="edit_image_desc_textarea_{%=file.image_id%}" rows="3"></textarea>
                        <span class="help-block" style="display:none"></span>
                    </div>
                    <div class="form-group">
                        <label for="image_preview_checkbox_{%=file.image_id%}" class="checkbox image-preview-checkbox-label">
                            <input type="checkbox" id="image_preview_checkbox_{%=file.image_id%}" class="image-preview-checkbox">
                            <span class="a-spr"></span> {%=translate("dealsModule", "Preview")%}
                        </label>
                        <br>
                        <span class="help-block" style="display:none"></span>
                    </div>


                    <!--div class="size">{%=o.formatFileSize(file.size)%}</div-->
                </div>
                <div class="col-lg-3">
                    <a href="" class="delete btn btn-danger delete-image" data-image="{%=file.image_id%}">{%=translate("core", "Delete")%}</a>
                </div>
            </div>
        </div>
    {% } %}
{% } %}
</script>
