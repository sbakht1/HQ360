<style>
    .links {color:#111;}
    .links:hover {text-decoration:none;color:#111;}
</style>
<hr>
<div class="row mt-4">
    <a class="col-md-4 links" href="<?= base_url()."/hubs?category=1";?>">
        <?= card('start'); ?>
            <h3>HR HUB</h3>
            <p>Request Time Off, Job Openings, Ask HR and more.</p>
        <?= card('end'); ?>
    </a>
    <a class="col-md-4 links" href="<?= base_url()."/hubs?category=2";?>">
        <?= card('start'); ?>
            <h4>TRAINING AND DEVELOPMENT HUB</h4>
            <p>Links, docs & all things training related.</p>
        <?= card('end'); ?>
    </a>
    <a class="col-md-4 links" href="<?= base_url()."/articles";?>">
        <?= card('start'); ?>
            <h4>KNOWLEDGE BASE</h4>
            <p>TWE Way, Policies, FAQs and more.</p>
        <?= card('end'); ?>
    </a>
</div>