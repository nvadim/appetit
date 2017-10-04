setTimeout(function(){
	$('#clock').countdown($('.element_date').val(), function(event) {
		 
	   var totalHours = event.offset.totalDays * 24 + event.offset.hours;
	   $(this).html(event.strftime('%-D '+declension(event.offset.totalDays,['день','дня','дней'])+' %-H ч %M м'));
	});
}, 0)	 

function declension(num, expressions) {
    var result;
    count = num % 100;
    if (count >= 5 && count <= 20) {
        result = expressions['2'];
    } else {
        count = count % 10;
        if (count == 1) {
            result = expressions['0'];
        } else if (count >= 2 && count <= 4) {
            result = expressions['1'];
        } else {
            result = expressions['2'];
        }
    }
    return result;
}

VK.init({
	apiId: window.vk_app_id,
});
function sendwallpost() {
	VK.Api.call('wall.post', { 
					owner_id : window.vk_id,
					attachments : window.photo_id + ','+$('.url_repost').val(),
					message : $('.text_repost').val().replace(/<br\s*[\/]?>/gi, "\n"),
				}, function (post) {
				    VK.api('users.get',{
						fields: 'first_name,last_name,photo_200'
					},function(data){
						$.ajax({
							url: '/bitrix/components/bd/surprise.repost/classes/vk.php',
				            type: "POST",
				            data:{
				                action: 'addMember',
				                element_id: $('.element___id').val(),
				                name: data.response[0].first_name+' '+data.response[0].last_name,
				                url: 'http://vk.com/id'+data.response[0].uid,
				                vk_id: data.response[0].uid,
				                photo_url: data.response[0].photo_200,
				                post_id: post.response.post_id,
				                ajax_params: $('.ajax_params').val()          
				            },
				            success: function(data){
					            $.cookie('already_repost', $('.element___id').val(), {path: '/'});
					            $('#post').hide();
					            $('#already_repost').show();
				            }
			            });
					});
				});	
    
}
function authInfo(response) {
  if (response.session) {
	  window.vk_id =  parseInt(response.session.mid);
	  $('#login_button').hide();
	  $('#post').show();
	  VK.Api.call('photos.getWallUploadServer', {
		uid : response.session.mid
	}, function (answer) {
		up_url = answer.response.upload_url; 
		$.post('/bitrix/components/bd/surprise.repost/classes/vk_upload.php', 
		{
			url: up_url,
			photo : $('.image_for_vk').val(),
			ajax_params: $('.ajax_params').val()
		}, function (request) {
			var p = JSON.parse(request);
			VK.Api.call('photos.saveWallPhoto',{user_id:response.session.mid,server: p.server,hash:p.hash,photo: p.photo}, function (result) { 	
				window.photo_id =result.response[0].id;
				
			});
		});
		});
  }
} 
VK.Auth.getLoginStatus(authInfo);
VK.UI.button('login_button'); 
function randomuser(){
	$.ajax({
			url: '/bitrix/components/bd/surprise.repost/classes/vk.php',
            type: "POST",
            dataType: 'json',
            data:{
                action: 'random',
                element_id: $('.element___id').val(), 
                ajax_params: $('.ajax_params').val()         
            },
            success: function(data){
	            window.location.reload();
            }
    });
}
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD (Register as an anonymous module)
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (arguments.length > 1 && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {},
			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling $.cookie().
			cookies = document.cookie ? document.cookie.split('; ') : [],
			i = 0,
			l = cookies.length;

		for (; i < l; i++) {
			var parts = cookies[i].split('='),
				name = decode(parts.shift()),
				cookie = parts.join('=');

			if (key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));