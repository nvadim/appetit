var ModalEffects=function(){function e(){var e=document.querySelector(".md-overlay");[].slice.call(document.querySelectorAll(".md-trigger")).forEach(function(t,c){function s(t){classie.remove(n,"md-show"),classie.remove(e,"md-show"),t&&classie.remove(document.documentElement,"md-perspective")}function o(){s(classie.has(t,"md-setperspective"))}var n=document.querySelector("#"+t.getAttribute("data-modal")),d=n.querySelector(".md-close");t.addEventListener("click",function(c){classie.add(n,"md-show"),classie.add(e,"md-show"),e.removeEventListener("click",o),e.addEventListener("click",o),classie.has(t,"md-setperspective")&&setTimeout(function(){classie.add(document.documentElement,"md-perspective")},25)}),null!==d&&d.addEventListener("click",function(e){e.stopPropagation(),o()})})}e()}();