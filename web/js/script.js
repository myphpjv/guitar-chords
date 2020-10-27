function setSelected(obj) {
    obj.parents('ul').find('li').removeClass('selected');
    obj.addClass('selected');
}

function setSelectedId(id) {
    var url = $('.switch-chord').data('url');
    $.post(url + '/' + id, function (data) {
        if (data == false) {
            console.log('fingering was not remembered');
        }
    })
}

function drawChord() {
    var translate = $('#chord-image').data('chord'),
        img = document.createElement('img'),
        title = translate + ' ' + getChordName(),
        fingering = $('.list-fingerings ul li.selected').data('value'),
        link = window.location.origin + '/uploads/' + fingering + '.png';

    $(img).attr('src', link).attr('title', title).attr('alt', title);
    $('#chord-image').html('').append(img);
    $('.chord-image-url').val(link);
    $('.download-image').attr('href', link).attr('download', getChordName() + '.png');
    setSelectedId(fingering);
}

function getChordName() {
    var tone = $('.list-tones ul li.selected').text(),
        type = $('.list-types ul li.selected').text();
    return tone + type;
}


function loadFingerings() {
    var tone = $('.list-tones ul li.selected').data('value'),
        type = $('.list-types ul li.selected').data('value'),
        url = $('.chords-select').data('url');

    $.get(url + '/' + tone + '/' + type, function (data) {
        $('.list-fingerings ul').find('li').remove();
        var i = 0;

        $.each(data, function (key, val) {
            var selected = i === 0 ? 'selected' : '';
            $('.list-fingerings ul').append('<li class="' + selected + '"' + ' data-value='
                + val.id + '>' + val.frets + '</li>');
            i++;
        });
        drawChord();
    });
}

function scrollList(obj, direction, shifting) {
    var childPos = obj.offset(),
        parentPos = obj.parent().offset(),
        listHeight = obj.parents('.list-inline').height();


    if (childPos !== undefined && parentPos !== undefined) {

        if (direction === 'down') {
            var offsetTop = childPos.top - parentPos.top;
            if (offsetTop > listHeight) {
                var diff = offsetTop - listHeight;
                $(".list-fingerings").animate({scrollTop: diff + 25 + shifting}, 50);
            }
        }

        if (direction === 'up') {
            var objPositionY = obj.position().top,
                listPositionYTop = obj.parents('.list-inline').position().top;
            if (objPositionY < listPositionYTop) {
                var diffUp = childPos.top - parentPos.top;
                $(".list-fingerings").animate({scrollTop: diffUp}, 50);
            }
        }
    }
}

$(document).ready(function () {
    scrollList($('.list-fingerings').find('li.selected'), 'down', 100);
    $('.menu .item').tab();
    $('.language-select').on('change', function () {
        $(this).closest('form').submit();
    });

    $('body').on('click', '.list-tones ul li, .list-types ul li', function () {
        var $this = $(this);
        setSelected($this);
        loadFingerings();
    }).on('click', '.list-fingerings ul li', function () {
        var $this = $(this);
        setSelected($this);
        drawChord();
    }).on('click', '.copy-chord-url', function () {
        var $this = $(this), urlInput = $('.chord-image-url')
        .popover('show');
        urlInput.select();
        document.execCommand("copy");
        setTimeout(function () {
            $('.chord-image-url').popover('hide');
        }, 5000);

    }).on('click', '.chord-next', function () {
        var selectedChord = $('.list-fingerings ul li.selected').next('li');
        setSelected(selectedChord);
        drawChord();
        scrollList(selectedChord, 'down', 0);

    }).on('click', '.chord-prev', function () {
        var selectedChord = $('.list-fingerings ul li.selected').prev('li');
        setSelected(selectedChord);
        drawChord();
        scrollList(selectedChord, 'up', 0);
    }).on('click', '.show-chords', function () {
        var $this = $(this), ul = $this.next('.total-chords-list');
        if(!ul.is(':visible')) {
            $this.removeClass('fa-plus-square-o').addClass('fa-minus-square-o')
        } else {
            $this.removeClass('fa-minus-square-o').addClass('fa-plus-square-o')
        }
        ul.slideToggle();
        ul.find('.chord-link').tooltip({
            'html' : true
        });
    }).on('change', '.chords-filter', function () {
        var $this = $(this);
        $this.parents('form').submit();
    });
});

$(document).ajaxStart(function () {
    $(".loader-wrap").show();
});

$(document).ajaxStop(function () {
    $(".loader-wrap").hide();
});

