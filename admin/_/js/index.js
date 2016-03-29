$('#markdown-modal form#markdown-form').submit(function(e){
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    formData.append('filepath',$('#markdown-modal form button[type="submit"]').attr('path'));

    $.ajax({
        url: 'functionality/update.php',
        type: 'POST',
        data:formData,
        processData: false,
        contentType: false,
        success: function(response){
            location.reload();
        }
    });
});

$('form#login-form').submit(function(e){
    e.preventDefault();
    var formData = new FormData($(this)[0]);

    $.ajax({
        url: 'functionality/login.php',
        type: 'POST',
        data:formData,
        processData: false,
        contentType: false,
        success: function(response){
            if(response=="Password error."){
                $('#passwordinput').addClass('error-login');
                $('#usernameinput').removeClass('error-login');
            }else if(response=="Username error."){
                $('#passwordinput').removeClass('error-login');
                $('#usernameinput').addClass('error-login');
            }else{
                $('#passwordinput').removeClass('error-login');
                $('#usernameinput').removeClass('error-login');
                location.href="index.php";
            }
        }
    });
});

$('#create-modal form#create-form').submit(function(e){
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    formData.append('filepath',$('#create-modal form button[type="submit"]').attr('path'));

    $.ajax({
        url: 'functionality/create.php',
        type: 'POST',
        data:formData,
        processData: false,
        contentType: false,
        success: function(response){
            location.reload();
        }
    });
});

$('#create-modal').on('show.bs.modal', function(e){
    path=$(e.relatedTarget).parent().parent().find('.row').eq(1).attr('path');
    $('#create-modal .front-matter').remove();

    $.ajax({
        url: 'functionality/retrieve.php',
        type: 'POST',
        data:{filepath: path},
        dataType: 'json',
        success: function(response){
            $.each(response['front-matter'],function(key,value){
                if((key=="image")||(key=="img")){
                    $('#create-modal .modal-body').prepend(
                        '<div class="form-group front-matter">'+
                            '<label class="col-md-1 control-label" for="title">'+key+'</label>'+
                            '<div class="col-md-11">'+
                                '<input id="'+key+'" name="'+key+'" class="form-control input-md image-input" type="file">'+
                            '</div>'+
                        '</div>'
                    );

                    $("#create-modal .image-input").fileinput({
                        overwriteInitial: true,
                        showUpload: false
                    });

                }else{

                    $('#create-modal .modal-body').prepend(
                        '<div class="form-group front-matter">'+
                            '<label class="col-md-1 control-label" for="title">'+key+'</label>'+
                            '<div class="col-md-11">'+
                                '<input id="'+key+'" required name="'+key+'" class="form-control input-md" type="text">'+
                            '</div>'+
                        '</div>'
                    );
                }
            });

            $('#create-modal form button[type="submit"]').attr('path',path);

            status_update();
        }
    });
});

$('#markdown-modal').on('show.bs.modal', function(e){
    var path=$(e.relatedTarget).parentsUntil(".row").parent().attr('path');

    $('#markdown-modal .front-matter').remove();

    $.ajax({
        url: 'functionality/retrieve.php',
        type: 'POST',
        data:{filepath: path},
        dataType: 'json',
        success: function(response){
            $('#markdown-modal .modal-title').text(path);
            $.each(response['front-matter'],function(key,value){
                if((key=="image")||(key=="img")){
                    $('#markdown-modal .modal-body').prepend(
                        '<div class="form-group front-matter">'+
                            '<label class="col-md-1 control-label" for="title">'+key+'</label>'+
                            '<div class="col-md-11">'+
                                '<input id="'+key+'" name="'+key+'" class="form-control input-md image-input" type="file">'+
                            '</div>'+
                        '</div>'
                    );

                    $('#markdown-modal .modal-body').prepend(
                        '<div class="form-group front-matter">'+
                            '<input name="current-image" class="hidden form-control input-md"  value="'+value+'"type="text">'+
                        '</div>'
                    );

                    $("#markdown-modal .image-input").fileinput({
                        initialPreview: [
                            '<img src="jekyll-cms/'+value+'" class="file-preview-image">'
                        ],
                        overwriteInitial: true,
                        showUpload: false
                    });

                }else{

                    $('#markdown-modal .modal-body').prepend(
                        '<div class="form-group front-matter">'+
                            '<label class="col-md-1 control-label" for="title">'+key+'</label>'+
                            '<div class="col-md-11">'+
                                '<input id="'+key+'" name="'+key+'" required class="form-control input-md" value="'+value+'" type="text">'+
                            '</div>'+
                        '</div>'
                    );
                }
            });

            $('#markdown-modal #content').val(response.content);
            $('#markdown-modal form button[type="submit"]').attr('path',path);

            status_update();
        }
    });
});

$('.btn-delete').on('click',function(e){
    var path=$(this).parentsUntil(".row").parent().attr('path');
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    },function(){
        $.ajax({
            url: 'functionality/delete.php',
            type: 'POST',
            data:{filepath: path},
            success: function(response){
                location.reload();
            }
        });
    });
});

$('.btn-deploy').on('click',function(e){
    $.ajax({
        url: 'functionality/deploy.php',
        type: 'GET',
        success: function(response){
            location.reload();
        }
    });
});

function status_update(){
    $.ajax({
        url: 'functionality/status.php',
        type: 'GET',
        success: function(response){
            var red_light = $('.status-lights .status-red');
            var green_light = $('.status-lights .status-green');
            var deploy_button = $('.btn-deploy');

            if(response=='true'){
                if(red_light.hasClass('status-off')){
                    red_light.removeClass('status-off');
                    red_light.addClass('status-on');
                    green_light.addClass('status-off');
                    green_light.removeClass('status-on');
                }
                deploy_button.prop('disabled',false);
            }else{
                if(green_light.hasClass('status-off')){
                    green_light.removeClass('status-off');
                    green_light.addClass('status-on');
                    red_light.addClass('status-off');
                    red_light.removeClass('status-on');
                }
            }
        }
    });
}

$('.logout').on('click',function(e){
    $.ajax({
        url: 'functionality/logout.php',
        type: 'GET',
        success: function(response){
            location.reload();
        }
    });
});

$(document).ajaxStart(function() {
    $('.modal').modal('hide');
    $('#ajax-loader').removeClass('hidden');
    $('body').css('overflow-y','hidden');
});

$(document).ajaxComplete(function() {
    $('#ajax-loader').addClass('hidden');
    $('body').css('overflow-y','auto');
});

status_update();
