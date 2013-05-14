<!--, /buildtree/js/jquery.cookies.js,/buildtree/js/jquery.treeview.js,/buildtree/js/demo.js-->
<script type="text/javascript" src="/buildtree/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/buildtree/js/jquery.treeview.js"></script>

<ul id="navigation" class="treeview" >
<!--    --><?php //foreach($categories as $category): ?>
<!--        <li>-->
<!--            <a href="--><?php //echo url_for('@videos?order=d&category='.$category->getTitle()); ?><!--">--><?php //echo $category->getTitle(); ?><!--</a>-->
            <?php echo CategoryTable::buildTree(); ?>
<!--        </li>-->
<!--    --><?php //endforeach; ?>
</ul>
<script type="text/javascript" src="/buildtree/js/demo.js"></script>