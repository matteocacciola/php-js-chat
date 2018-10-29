$(document).ready(function () {
        $.timeago.settings.cutoff = 1000 * 60 * 60 * 24; // Display original dates older than 24 hours

        $('.showchat').on('click', function (event) {
            event.preventDefault();
            var $chat = $('#chat'), interval, url = this.href;
            $chat.removeAttr('style');
            $chat.load(url, function () {
                var $chatDiscussion = $chat.find('.discussion');
                $chatDiscussion
                        .scrollTop($chatDiscussion.get(0).scrollHeight)
                        .on('scroll', function () {
                            sessionStorage.setItem('scrollTopDiscussion', $chatDiscussion.scrollTop());
                        });
                ;
                $chat.find('time.timeago').timeago();
                $chat.find('.close-chat').on('click', function() {
                    clearInterval(interval);
                    $chat.slideToggle('slow');
                    $chat.empty();
                    sessionStorage.removeItem('scrollTopDiscussion');
                    return false;
                });
                $chat.find('.toggle-chat, .top-bar').on('click', function () {
                    $chat.find('.toggle-chat')
                            .toggleClass('fa-window-maximize')
                            .toggleClass('fa-window-minimize')
                    ;
                    $chat.find('.body-chat').slideToggle('slow');
                    return false;
                });
                $chat.find('textarea').on('keypress', function (event) {
                    if (event.keyCode === 13 ) {
                        var $this = $(this),
                                msg = $this.val(),
                                urlMessage = $this.data('url')
                        ;
                        $this.val().replace(/\n/g, '');
                        $this.val('');
                        if (msg.trim().length !== 0){
                            $.ajax({
                                url: urlMessage,
                                method: 'POST',
                                data: {
                                    message: msg
                                },
                                dataType: 'json',
                                success: function (response) {
                                    var $html = $(response.result);
                                    $chat.find('.discussion').replaceWith($html.find('.discussion'));
                                    $chat.find('time.timeago').timeago();
                                },
                                complete: function (jqXHR, textStatus) {
                                    var $chatDiscussion = $chat.find('.discussion');
                                    $chatDiscussion.scrollTop($chatDiscussion.get(0).scrollHeight);
                                    sessionStorage.setItem('scrollTopDiscussion', $chatDiscussion.scrollTop());
                                    $chatDiscussion.on('scroll', function () {
                                        sessionStorage.setItem('scrollTopDiscussion', $chatDiscussion.scrollTop());
                                    });
                                }
                            });
                            return false;
                        }
                    }
                });
                interval = setInterval(function () {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'html',
                        success: function (response) {
                            var $html = $(response);
                            $chat.find('.discussion').replaceWith($html.find('.discussion'));
                            $chat.find('time.timeago').timeago();
                        },
                        complete: function (jqXHR, textStatus) {
                            var $chatDiscussion = $chat.find('.discussion');
                            $chatDiscussion.on('scroll', function () {
                                sessionStorage.setItem('scrollTopDiscussion', $chatDiscussion.scrollTop());
                            });
                            if (sessionStorage.getItem('scrollTopDiscussion') !== null) {
                                $chat.find('.discussion').scrollTop(sessionStorage.getItem('scrollTopDiscussion'));
                            }
                        }
                    });
                }, 5000);
            });
        });
    });
