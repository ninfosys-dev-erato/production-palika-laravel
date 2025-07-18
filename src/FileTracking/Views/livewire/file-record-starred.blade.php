<form wire:submit.prevent>
    <div class="flex-grow-1 container-p-y">
        <div class="row g-6">
            <div class="col-md-12">
                <div class="row flex-column mt-4">
                    <div class="d-flex justify-content-end align-items-center w-100">

                        <!-- Search Input -->
                        <div class="form-group">
                            <label for="">{{__('filetracking::filetracking.search')}}</label>
                            <div class="input-group">
                                <input type="text" wire:model.live.debounce.300ms="searchTerm" wire:keydown.enter="Search" class="form-control" placeholder="{{__('filetracking::filetracking.search')}} ...">
                                <button class="btn btn-primary" wire:click="Search"  type="button" id="button-addon2">
                                    <i class="bx bx-search-alt"></i>
                                </button>
                                <button class="btn btn-secondary" type="button" wire:click="clearSearch">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Pagination Info and Controls -->
                        <div class="right-side-menu d-flex align-items-center gap-2">
                            <div class="text-center text-md-right text-muted">
                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $fileRecords->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Tabs Section -->
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                    aria-selected="true">
                                <span class="d-none d-sm-block">
                                    <i class="tf-icons bx bx-copy-alt bx-sm me-1_5 align-text-bottom"></i>
                                    {{__('filetracking::filetracking.all_letters')}}
                                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">
                                        {{ replaceNumbersWithLocale($fileRecords->total(), true) }}
                                    </span>
                                </span>
                                <i class="bx bx-home bx-sm d-sm-none"></i>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" style="background-color:inherit;box-shadow:none;>
                        <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                            <div class="table-container"
                                 style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #c1c1c1 #f1f1f1;">
                                <table class="table card-table">
                                    <tbody class="table-border-bottom-0">
                                    @forelse ($fileRecords as $fileRecord)
                                        <livewire:file_tracking.file_record_manage_row :fileRecord="$fileRecord"
                                                                                       :key="$fileRecord->id" />
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">No records available.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>


