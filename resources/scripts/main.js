$(function () {
    $('.dropdown-toggle').dropdown();

    let $source = $('#sourcecode');
    if ($source.length) {
        let value = $source.text();
        let mode = $source.attr('language');
        let pre = $source.get(0);
        let viewer = CodeMirror(function(elt) {
            pre.parentNode.replaceChild(elt, pre);
        }, {
            value: value,
            lineNumbers: true,
            matchBrackets: true,
            lineWrapping: true,
            readOnly: true,
            mode: mode,
            lineNumberFormatter: function(ln) {
                return '<a name="L'+ ln +'"></a><a href="#L'+ ln +'">'+ ln +'</a>';
            }
        });
    }

    if ($('#md-content').length) {
      console.log('md-content');
        //let converter = new Showdown.converter({extensions: ['table']});
        let converter = new Showdown.converter();
        $('#md-content').html(converter.makeHtml($('#md-content').text()));
    }

    let clonePopup = $('#clone-popup');
    let cloneButtonShow = $('#clone-button-show');
    let cloneButtonHide = $('#clone-button-hide');
    let cloneButtonSSH = $('#clone-button-ssh');
    let cloneButtonHTTP = $('#clone-button-http');
    let cloneInputSSH = $('#clone-input-ssh');
    let cloneInputHTTP = $('#clone-input-http');

    cloneButtonShow.click(function()
    {
        clonePopup.fadeIn();
    });

    cloneButtonHide.click(function()
    {
        clonePopup.fadeOut();
    });

    cloneButtonSSH.click(function()
    {
        if(cloneButtonSSH.hasClass('active'))
            return;

        cloneButtonSSH.addClass('active');
        cloneInputSSH.show();

        cloneButtonHTTP.removeClass('active');
        cloneInputHTTP.hide();
    });

    cloneButtonHTTP.click(function()
    {
        if(cloneButtonHTTP.hasClass('active'))
            return;

        cloneButtonHTTP.addClass('active');
        cloneInputHTTP.show();

        cloneButtonSSH.removeClass('active');
        cloneInputSSH.hide();
    });

});
