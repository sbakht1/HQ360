<div class="card card-statistics">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="statistics-item">
            <p><i class="icon-sm fa fa-users mr-2"></i>Employees</p>
            <h2><?= $numbers['employees'];?></h2>
            </div>
            <div class="statistics-item">
            <p>
                <i class="icon-sm fas fa-store mr-2"></i>
                Stores
            </p>
            <h2><?= $numbers['stores']; ?></h2>
            </div>
            <div class="statistics-item">
            <p>
                <i class="icon-sm fas fa-map mr-2"></i>
                Districts
            </p>
            <h2><?= $numbers['districts'];?></h2>
            </div>
            <div class="statistics-item">
            <p>
                <i class="icon-sm fas fa-check-circle mr-2"></i>
                Tickets Not Closed
            </p>
            <h2><?= $numbers['open_tickets'];?></h2>
            </div>
        </div>
    </div>
</div>