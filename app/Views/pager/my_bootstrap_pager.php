<?php $pager->setSurroundCount(2); ?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-sibayak justify-content-center">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                    <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="page-link">
                    <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
            <li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link">
                    <span aria-hidden="true"><?= lang('Pager.next') ?></span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link">
                    <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>