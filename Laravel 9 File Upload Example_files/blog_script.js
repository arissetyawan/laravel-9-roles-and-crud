var WINDOW_HEIGHT = $(window).height(), ACTIVE_HANDLER = '';

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

const handle = document.querySelector("[property='article:handle']");

if (handle && handle.content) {
    const key = handle.content;
    const exist = getCookie(key);
    if (!exist) {
        $.ajax({
            type: 'GET',
            url: '/new/view/' + key,
            success: function(json) {
                setCookie(key, 'new', 1);
            }
        });
    }
}

var articleProgressBar = document.getElementById('articlePregressBarContainer');
var articleProgressHandle = document.getElementById('articleProgressHandle');

var article = {
    contents: [],

    initContents() {

        $('#ArticleBody').html(function(i, html) {
            html = html.replace(/&nbsp;/g, ' ');
            return html;
        });
        $('#ArticleBody p').map(function(i, p) {
            if (!p.innerHTML.trim()) {
                p.innerHTML = p.innerHTML.split(' ').join('&nbsp;');
            }
        });
        $('#ArticleBody ul').map(function(i, ul) {
            $(ul).addClass('list-disc pl-6');
        });
        $('#ArticleBody ol').map(function(i, ol) {
            $(ol).addClass('list-decimal pl-6');
        });

        const sections = document.getElementsByClassName('article-section-title');
        const array = Array.from(sections);
        const sectionContainer = $('#TableOfContents');
        var top = '<li class="relative mb-4 transition duration-150 ease-in-out">';
        top += '<a href="#-top-" class="scroll-handler flex items-centyer pr-3 py-1.5 font-semibold text-gray-500 cursor-pointer hover:text-indigo-600 transition duration-150 ease-in-out">';
        top += '<svg class="h-5 w-5 -ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>';
        top += 'Top</a></li>';
        sectionContainer.append(top);
        array.map((item, i) => {
            var html = '<li class="relative border-l transition duration-150 ease-in-out">';
            html += '<a href="#'+item.id+'" class="scroll-handler block px-3 py-1.5 font-semibold text-gray-500 cursor-pointer hover:text-indigo-600 transition duration-150 ease-in-out" data-content-id="'+item.id+'">'+item.innerText+'</a>';
            html += '</li>';
            sectionContainer.append(html);
            var mobileHtml = '<li class="relative transition duration-150 ease-in-out">';
            mobileHtml += '<a href="#'+item.id+'" class="block px-3 py-1.5 font-semibold text-gray-500 cursor-pointer hover:text-indigo-600 transition duration-150 ease-in-out">'+item.innerText+'</a>';
            mobileHtml += '</li>';
            $('#TableOfContentsMobile').append(mobileHtml);
        });

        var bottom = '<li class="relative mt-4 transition duration-150 ease-in-out">';
        bottom += '<a href="#-bottom-" class="scroll-handler flex items-centyer pr-3 py-1.5 font-semibold text-gray-500 cursor-pointer hover:text-indigo-600 transition duration-150 ease-in-out">';
        bottom += '<svg class="h-5 w-5 -ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
        bottom += 'Bottom</a></li>';
        sectionContainer.append(bottom);
    },

    scrollToContent(id) {
        const el = document.getElementById(id);
        if (el) {
            el.scrollIntoView();
        }
    },

    adContentHtml(isP) {
        var styleContent = "margin-bottom: 20px;margin-top: 20px;";
        if(isP) {
            styleContent = "margin-bottom: 20px;";
        }
        return '<div class="bybit-ad"><a href="/bybit?utm_source=codeanddeploy&utm_medium=top-content" target="_blank" rel="nofollow"><img src="https://codeanddeploy.com/uploads/BYBIT-CONTENT.png" alt="Image" style="'+styleContent+'" class="bybit-bordered"></a></div>';
    },

    insertAdsonContent() {
        $('#ArticleBody p').eq(5).after(article.adContentHtml(1));
        
        $("#ArticleBody .article-section-title").next('p').after(article.adContentHtml(0));
    },


};

article.initContents();
article.insertAdsonContent();

function setActiveHandler() {
    var m = 0;
    $('#TableOfContents li').map(function(x, v) {
        $(v).removeClass('border-blue-500');
    });

    var sTop = $(window).scrollTop(), sBottom = WINDOW_HEIGHT + sTop, len = article.contents.length;
    for(var i = 0; i < len; i++){
        if (article.contents[i].top > sTop) {
            ACTIVE_HANDLER = article.contents[i].id;
            m = i;
            break;
        }
    }
    if (article.contents[m+1] && article.contents[m+1].top > sBottom) {
        var t = m ? (m - 1) : m;
        ACTIVE_HANDLER = article.contents[t].id;
    }
    $('.scroll-handler').removeClass('text-indigo-600');
    if (ACTIVE_HANDLER) {
        var handler = $('[data-content-id="'+ACTIVE_HANDLER+'"]');
        handler.addClass('text-indigo-600');
        handler.parent('li').addClass('border-blue-500');
    }
}

$(window).on("load", function() {
    var sectionTitles = $('.article-section-title');
    for (var i = 0; i < sectionTitles.length; i++) {
        var eTop = parseInt($(sectionTitles[i]).offset().top + $(sectionTitles[i]).height());
        if (sectionTitles[i+1]) {
            eTop = parseInt($(sectionTitles[i+1]).offset().top);
        }
        article.contents.push({
            id: sectionTitles[i].id,
            top: eTop
        });
    }

    setActiveHandler();
    $(window).scroll(function() {
        setActiveHandler();
    });
});