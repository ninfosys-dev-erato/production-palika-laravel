<div class="container py-4">
  <!-- Main Setting Card -->
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card border-1">
        <div class="card-header text-white text-center py-3">
          <h4 class="mb-1">EBPS Filter Setting</h4>
          <small>Control application visibility for your municipality</small>
        </div>

        <div class="card-body py-4 px-3">
          <!-- Current Status -->
          <div class="text-center mb-4">
            @if($isEnabled)
              <h5 class="text-success mb-1">Role Filtering is ENABLED</h5>
              <small class="text-muted">Users only see applications they can work on based on their roles</small>
            @else
              <h5 class="text-secondary mb-1">Role Filtering is DISABLED</h5>
              <small class="text-muted">All users see all applications regardless of roles</small>
            @endif
          </div>

          <!-- Action Buttons -->
          <div class="d-flex gap-2 mb-4">
            <button type="button" 
                    class="btn btn-success flex-fill"
                    wire:click="enableFiltering"
                    {{ $isEnabled ? 'disabled' : '' }}>
              Enable Role Filtering
            </button>
            <button type="button" 
                    class="btn btn-outline-secondary flex-fill"
                    wire:click="disableFiltering"
                    {{ !$isEnabled ? 'disabled' : '' }}>
              Show All Applications
            </button>
          </div>

          <!-- Quick Toggle Button -->
          <div class="text-center mb-3">
            <button type="button" class="btn btn-primary btn-sm px-4" wire:click="toggleFilter">
              Quick Toggle
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Information Cards -->
  <div class="row mt-3 gx-3">
    <div class="col-md-6 mb-3">
      <div class="card border-success h-100">
        <div class="card-header bg-success text-white py-2">
          Role Filtering ENABLED
        </div>
        <div class="card-body p-3 small">
          <ul class="mb-0 ps-3">
            <li>Users see relevant applications only</li>
            <li>Action buttons hidden unless authorized</li>
            <li>Better security and workflow control</li>
            <li>Recommended for most organizations</li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="col-md-6 mb-3">
      <div class="card border-secondary h-100">
        <div class="card-header bg-light text-secondary py-2">
          Show All Applications
        </div>
        <div class="card-body p-3 small">
          <ul class="mb-0 ps-3">
            <li>All users see all applications</li>
            <li>All action buttons visible to everyone</li>
            <li>Open access for all staff members</li>
            <li>Useful for small offices only</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Impact Notice -->
  <div class="row mt-3">
    <div class="col-12">
      <div class="alert alert-primary small text-center py-2 mb-0">
        <strong>Setting Impact:</strong> This affects application tables and step details across EBPS. Changes apply immediately.
      </div>
    </div>
  </div>

  <!-- Last Updated -->
  @if($currentSetting && $currentSetting->updated_at)
  <div class="row mt-2">
    <div class="col-12 text-center text-muted small">
      Last updated: {{ $currentSetting->updated_at->format('M d, Y \a\t h:i A') }}
      @if($currentSetting->updated_by)
        by User ID: {{ $currentSetting->updated_by }}
      @endif
    </div>
  </div>
  @endif
</div>
