<div class="sub_menu">
    <div class="wrapper">
        <ul>
            <li>
                <a href="<?php echo url_for('@videos?order=d'); ?>">Добавленые</a>
            </li>
            <li>
                <a href="<?php echo url_for('@videos?order=v'); ?>">Просмотренные</a>
            </li>
            <li>
                <a href="<?php echo url_for('@videos?order=c'); ?>">Обсуждаемые</a>
            </li>
            <li>
                <a href="<?php echo url_for('@videos?order=r'); ?>">Лучшие</a>
            </li>
        </ul>
    </div>
</div>