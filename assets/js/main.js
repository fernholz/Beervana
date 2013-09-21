$( document ).ready(function() {
    $('.list-group-item input, .list-group-item textarea, .list-group-item select').change(function() {
        console.log($(this));

        var username = getUrlVars()['username'];
        var updated = $(this).attr('name');
        var value = $(this).val();
        if(value === '1') {
            if(!$(this).is(':checked')) {
                value = 0;
            }
        }
        var beerLocation = $(this).closest('.panel-primary').find('.beer-location').text();

        $.ajax({
            type: "POST",
            url: '../../beers/update.php',
            data: {
                username: username,
                updated: updated,
                value: value,
                beerLocation: beerLocation
            },
            async: false
        })
            .done(function(response) {

            });

    });

    $('.beer-list').first().toggle();
    $('.toggle-beer-location').first().toggleClass('glyphicon-circle-arrow-up').toggleClass('glyphicon-circle-arrow-down');

    $('.toggle-beer-location').click(function() {
        $(this).closest('.panel-primary').find('.beer-list').toggle();
        $(this).toggleClass('glyphicon-circle-arrow-up');
        $(this).toggleClass('glyphicon-circle-arrow-down');
    });
});

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}