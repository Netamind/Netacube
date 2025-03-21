'use strict'; $(document).ready(function () {
    var console = window.console || { log: function () { } }; var URL = window.URL || window.webkitURL; var $image = $('#image'); var $download = $('#download'); var $dataX = $('#dataX'); var $dataY = $('#dataY'); var $dataHeight = $('#dataHeight'); var $dataWidth = $('#dataWidth'); var $dataRotate = $('#dataRotate'); var $dataScaleX = $('#dataScaleX'); var $dataScaleY = $('#dataScaleY'); var options = { aspectRatio: 16 / 9, preview: '.img-preview', crop: function (e) { $dataX.val(Math.round(e.x)); $dataY.val(Math.round(e.y)); $dataHeight.val(Math.round(e.height)); $dataWidth.val(Math.round(e.width)); $dataRotate.val(e.rotate); $dataScaleX.val(e.scaleX); $dataScaleY.val(e.scaleY); } }; var originalImageURL = $image.attr('src'); var uploadedImageURL; $image.on({ 'build.cropper': function (e) { }, 'built.cropper': function (e) { }, 'cropstart.cropper': function (e) { }, 'cropmove.cropper': function (e) { }, 'cropend.cropper': function (e) { }, 'crop.cropper': function (e) { }, 'zoom.cropper': function (e) { } }).cropper(options); if (!$.isFunction(document.createElement('canvas').getContext)) { $('button[data-method="getCroppedCanvas"]').prop('disabled', true); }
    if (typeof document.createElement('cropper').style.transition === 'undefined') { $('button[data-method="rotate"]').prop('disabled', true); $('button[data-method="scale"]').prop('disabled', true); }
    if (typeof $download[0].download === 'undefined') { $download.addClass('disabled'); }
    $('.docs-toggles').on('change', 'input', function () {
        var $this = $(this); var name = $this.attr('name'); var type = $this.prop('type'); var cropBoxData; var canvasData; if (!$image.data('cropper')) { return; }
        if (type === 'checkbox') { options[name] = $this.prop('checked'); cropBoxData = $image.cropper('getCropBoxData'); canvasData = $image.cropper('getCanvasData'); options.built = function () { $image.cropper('setCropBoxData', cropBoxData); $image.cropper('setCanvasData', canvasData); }; } else if (type === 'radio') { options[name] = $this.val(); }
        $image.cropper('destroy').cropper(options);
    }); $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this); var data = $this.data(); var $target; var result; if ($this.prop('disabled') || $this.hasClass('disabled')) { return; }
        if ($image.data('cropper') && data.method) {
            data = $.extend({}, data); if (typeof data.target !== 'undefined') { $target = $(data.target); if (typeof data.option === 'undefined') { try { data.option = JSON.parse($target.val()); } catch (e) { console.log(e.message); } } }
            if (data.method === 'rotate') { $image.cropper('clear'); }
            result = $image.cropper(data.method, data.option, data.secondOption); if (data.method === 'rotate') { $image.cropper('crop'); }
            switch (data.method) {
                case 'scaleX': case 'scaleY': $(this).data('option', -data.option); break; case 'getCroppedCanvas': if (result) { $('#getCroppedCanvasModal').modal().find('.modal-body').html(result); if (!$download.hasClass('disabled')) { $download.attr('href', result.toDataURL('image/jpeg')); } }
                    break; case 'destroy': if (uploadedImageURL) { URL.revokeObjectURL(uploadedImageURL); uploadedImageURL = ''; $image.attr('src', originalImageURL); }
                    break;
            }
            if ($.isPlainObject(result) && $target) { try { $target.val(JSON.stringify(result)); } catch (e) { console.log(e.message); } }
        }
    }); $(document.body).on('keydown', function (e) {
        if (!$image.data('cropper') || this.scrollTop > 300) { return; }
        switch (e.which) { case 37: e.preventDefault(); $image.cropper('move', -1, 0); break; case 38: e.preventDefault(); $image.cropper('move', 0, -1); break; case 39: e.preventDefault(); $image.cropper('move', 1, 0); break; case 40: e.preventDefault(); $image.cropper('move', 0, 1); break; }
    }); var $inputImage = $('#inputImage'); if (URL) {
        $inputImage.change(function () {
            var files = this.files; var file; if (!$image.data('cropper')) { return; }
            if (files && files.length) {
                file = files[0]; if (/^image\/\w+$/.test(file.type)) {
                    if (uploadedImageURL) { URL.revokeObjectURL(uploadedImageURL); }
                    uploadedImageURL = URL.createObjectURL(file); $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options); $inputImage.val('');
                } else { window.alert('Please choose an image file.'); }
            }
        });
    } else { $inputImage.prop('disabled', true).parent().addClass('disabled'); }
});



$(function () { $('.crop-basic').cropper(); $('.crop-modal').cropper({ modal: true }); 


$('.crop-not-movable').cropper({ 
    
    cropBoxMovable: false, data: { x: 75, y: 50, width: 350, height: 250 } 

});
    
    
    $('.crop-not-resizable').cropper({ cropBoxResizable: false, data: { x: 10, y: 10, width: 300, height: 300 } }); $('.crop-auto').cropper({ autoCrop: false }); $('.crop-drag').cropper({ movable: false }); $('.crop-16-9').cropper({ aspectRatio: 16 / 9 }); $('.crop-4-3').cropper({ aspectRatio: 4 / 3 }); $('.crop-min').cropper({ minCropBoxWidth: 150, minCropBoxHeight: 150 }); $('.crop-zoomable').cropper({ zoomable: false }); });