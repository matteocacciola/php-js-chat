<style>
    .module {
        width: 300px;
    }

    .top-bar {
        background: #666;
        color: white;
        padding: 0px 0.5rem;
        position: relative;
        overflow: hidden;
        cursor:pointer;
        border-radius: 4px 4px 0px 0px;
    }
    .top-bar h1 {
        display: inline;
        font-size: 0.85em;
    }
    .top-bar .fa-comments {
        display: inline-block;
        padding: 4px 5px 2px 5px;
    }
    .top-bar .left {
        float: left;
    }
    .top-bar .right {
        float: right;
        padding-bottom: 10px;
    }
    .top-bar .right i {
        cursor: pointer;
        font-size: 0.75em;
    }
    .top-bar .right .toggle-chat {
        font-size: 0.5em;
        margin-right: 5px;
    }
    .top-bar > * {
        position: relative;
    }

    .body-chat .discussion {
        list-style: none;
        background: #e5e5e5;
        margin: 0;
        padding: 0 0 20px 0;
        height: 200px;
        font-size: 12px;
        overflow: auto;
        overflow-x: hidden;
    }
    .body-chat .discussion li {
        padding: 10px 0.5rem 0px 0.5rem;
        overflow: hidden;
        display: inline-block;
        clear: both;
    }
    .body-chat .discussion li:last-of-type {
        padding-bottom: 10px;
    }
    .body-chat .bottom-input {
        background-color: #fff;
        border: 1px solid #e5e5e5;
        border-top: 1px solid #DDDDDD;
    }
    .body-chat .input {
        width: 100%;
        height: 30px !important;
        border: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box; 
        -moz-box-sizing: border-box;   
        box-sizing: border-box;
        resize: none;
        font-size: 0.75em;
        margin: 0px auto !important;
    }
    .body-chat .input:focus {
        box-shadow: none !important;
    }

    .self {
        justify-content: flex-end;
        align-items: flex-end;
        float: right;
    }
    .self .messages {
        float: right;
        background: #0084ff;
        color: #fff;
    }
    .self + .self .messages {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .self:last-of-type .messages {
        border-bottom-right-radius: 30px;
    }

    .other + .self .messages {
        border-bottom-right-radius: 5px;
    }

    .messages {
        background: white;
        padding: 20px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        border-radius: 30px;
    }
    .messages p {
        font-size: 0.9rem;
        margin: 0 0 0.2rem 0;
        word-break: break-all;
    }
    .messages time {
        font-size: 0.7rem;
        color: #fff;
    }
</style>

<section class="module">
    <header class="top-bar">
        <div class="left">
            <i class="fa fa-comments"></i>
            <h1>Thread</h1>
        </div>

        <div class="right">
            <i class="fa fa-window-minimize toggle-chat"></i>
            <i class="fa fa-times close-chat"></i>
        </div>
    </header>

    <div class="body-chat">
        <ol class="discussion">
            <?php foreach ($messages as $message) { ?>
                <?php $class = $message->isSentBy($user) ? 'self' : 'other'; ?>
                <?php $sender = $message->isSentBy($user) ? '' : $message->getSender->getName(); ?>
                <li class="<?php echo $class; ?>">
                    <div class="messages">
                        <p><?php echo nl2br($message->getBody()); ?></p>
                        <?php echo $sender; ?><?php if ($sender != '') {?> • <?php } ?>
                        <i class="fa fa-clock-o"></i> <time class="timeago" datetime="<?php echo $message->getCreatedAt()->format('c'); ?>"><?php $message->getCreatedAt()->format('M jS, Y \\a\\t g:ia'); ?></time>
                    </div>
                </li>
            <?php } ?>
        </ol>

        <div class="bottom-input">
            <textarea class="input" placeholder="Add a message" data-url="#url-to-form"></textarea>
        </div>
    </div>

</section>
