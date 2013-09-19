$( document ).ready(function() {
    $('.list-group-item input, .list-group-item textarea, .list-group-item select').change(function() {
        console.log($(this));

        var username = getUrlVars()['username'];
        var updated = $(this).attr('name');
        var value = $(this).val();
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
            async: true
        })
            .done(function(response) {

            });

    });
});

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}