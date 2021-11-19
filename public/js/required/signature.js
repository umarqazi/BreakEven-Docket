$(function() {
    var sig = $('#sig').signature();
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
    });

    $('#svg').click(function() {
        // console.log(saveSignatureUrl);
        // return;
        var signature = sig.signature('toDataURL');
        $.ajax({
            data : {img : signature},
            url : saveSignatureUrl,
            type : 'post',
			cache : false,
            success : function(){
                location.reload(true);
            }
        })
    });
});
