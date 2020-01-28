<nav class="navbar">
    <div class="nav-left">
        <?php foreach ($data['left'] as $link): ?>
            <a href="<?php print $link['url']; ?>"><?php print $link['title']; ?></a>
        <?php endforeach; ?>
        <?php foreach ($data['right'] as $link): ?>
            <a href="<?php print $link['url'] ?>"><?php print $link['title']; ?></a>
        <?php endforeach; ?>
    </div>
</nav>