<div class="d-flex gap-2 align-items-center" style="height: 70px;">
    <img class="bg-light rounded-circle h-100"
        src={{customAsset(config('src.Employees.employee.photo_path'), $row->photo)}}
        alt={{ __($row->name) }} style="width: 70px;">
    
    <div class="d-flex gap-0 flex-column justify-content-center ">
        <p class="fs-6 fw-bold m-0">
            {{ __($row->name) }}
        </p>
        
        <p class="fs-6 fw-medium m-0">
            {{ $row->{'designation.title'} ?? 'N/A' }}

        </p>
    </div>

</div>
