<form wire:submit.prevent>
    <div class="flex-grow-1 container-p-y">
        <div class="row g-6">
            <div class="col-md-12">
                <div class="row flex-column mt-4">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="btn-toolbar demo-inline-spacing" role="toolbar"
                            aria-label="Toolbar with button groups">
                            <div class="btn-group" role="group" aria-label="First group">
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="tf-icons bx bx-refresh"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="tf-icons bx bx-archive-in"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="tf-icons bx bx-envelope"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="tf-icons bx bx-envelope-open"></i>
                                </button>
                            </div>
                        </div>
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


                    </div>
                </div>
                <hr class="mb-4">
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link {{ $currentPage === 'file-records' ? 'active' : '' }}"
                                    wire:click="setActiveTab('file-records')"
                                    data-bs-toggle="tab" data-bs-target="#file-records"
                                    role="tab" aria-controls="file-records" aria-selected="{{ $currentPage === 'file-records' ? 'true' : 'false' }}">
                <span class="d-none d-sm-block"><i class="tf-icons bx bx-copy-alt bx-sm me-1_5 align-text-bottom"></i> {{__('filetracking::filetracking.all_letters')}}
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">{{ $total }}</span>
                </span><i class="bx bx-copy-alt bx-sm d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link {{ $currentPage === 'farsyaut-records' ? 'active' : '' }}"
                                    wire:click="setActiveTab('farsyaut-records')"
                                    data-bs-toggle="tab" data-bs-target="#farsyaut-records"
                                    role="tab" aria-controls="farsyaut-records" aria-selected="{{ $currentPage === 'farsyaut-records' ? 'true' : 'false' }}">
                <span class="d-none d-sm-block"><i class="tf-icons bx bx-user bx-sm me-1_5 align-text-bottom"></i> {{__('filetracking::filetracking.farsyaut')}}
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">{{ $farsyautCount }}</span>
                </span><i class="bx bx-user bx-sm d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link {{ $currentPage === 'nofarsyaut-records' ? 'active' : '' }}"
                                    wire:click="setActiveTab('nofarsyaut-records')"
                                    data-bs-toggle="tab" data-bs-target="#nofarsyaut-records"
                                    role="tab" aria-controls="nofarsyaut-records" aria-selected="{{ $currentPage === 'nofarsyaut-records' ? 'true' : 'false' }}">
                <span class="d-none d-sm-block"><i class="tf-icons bx bx-message-square bx-sm me-1_5 align-text-bottom"></i> {{__('filetracking::filetracking.no_farsyaut')}}
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">{{ $NoFarsyautCount }}</span>
                </span><i class="bx bx-message-square bx-sm d-sm-none"></i>
                            </button>
                        </li>
                        <li class="nav-item mb-1 mb-sm-0" role="presentation">
                            <button type="button" class="nav-link {{ $currentPage === 'archived-records' ? 'active' : '' }}"
                                    wire:click="setActiveTab('archived-records')"
                                    data-bs-toggle="tab" data-bs-target="#archived-records"
                                    role="tab" aria-controls="archived-records" aria-selected="{{ $currentPage === 'archived-records' ? 'true' : 'false' }}">
                <span class="d-none d-sm-block"><i class="tf-icons bx bx-archive bx-sm me-1_5 align-text-bottom"></i> {{__('filetracking::filetracking.archived')}}
                    <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">{{ $archivedCount }}</span>
                </span><i class="bx bx-archive bx-sm d-sm-none"></i>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" style="background-color:inherit;box-shadow:none;">
                        <div class="tab-pane fade {{ $currentPage === 'file-records' ? 'show active' : '' }}" id="file-records" role="tabpanel">
                            <div class="table-container" style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #c1c1c1 #f1f1f1;">
                                {{ $fileRecords?->links(data:['scrollTo' => false]) }}
                                <table class="table card-table ">
                                    <tbody class="table-border-bottom-0">
                                    @if($fileRecords)
                                        @foreach ($fileRecords as $fileRecord)
                                            @livewire('file_tracking.file_record_manage_row', ['fileRecord' => $fileRecord], key("rec-{$fileRecord->id}"))
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Farsyaut Records Tab --}}
                        <div class="tab-pane fade {{ $currentPage === 'farsyaut-records' ? 'show active' : '' }}" id="farsyaut-records" role="tabpanel">
                            <div class="table-container" style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #c1c1c1 #f1f1f1;">
                                {{ $farsyautRecords?->links(data:['scrollTo' => false]) }}
                                <table class="table card-table">
                                    <tbody class="table-border-bottom-0">
                                    @if($farsyautRecords)
                                        @foreach ($farsyautRecords as $fileRecord)
                                            @livewire('file_tracking.file_record_manage_row', ['fileRecord' => $fileRecord], key("far-{$fileRecord->id}"))
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- No Farsyaut Records Tab --}}
                        <div class="tab-pane fade {{ $currentPage === 'nofarsyaut-records' ? 'show active' : '' }}" id="nofarsyaut-records" role="tabpanel">
                            <div class="table-container" style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #c1c1c1 #f1f1f1;">
                                {{ $NoFarsyautRecords?->links(data:['scrollTo' => false]) }}
                                <table class="table card-table pd-4 bg-white">
                                    <tbody class="table-border-bottom-0">
                                    @if($NoFarsyautRecords)
                                        @foreach ($NoFarsyautRecords as $fileRecord)
                                            @livewire('file_tracking.file_record_manage_row', ['fileRecord' => $fileRecord], key("no-far-{$fileRecord->id}"))
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Archived Records Tab --}}
                        <div class="tab-pane fade {{ $currentPage === 'archived-records' ? 'show active' : '' }}" id="archived-records" role="tabpanel">
                            <div class="table-container" style="height: 500px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #c1c1c1 #f1f1f1;">
                                {{ $archivedRecords?->links(data:['scrollTo' => false]) }}
                                <table class="table card-table">
                                    <tbody class="table-border-bottom-0">
                                    @if($archivedRecords)
                                        @foreach ($archivedRecords as $fileRecord)
                                            @livewire('file_tracking.file_record_manage_row', ['fileRecord' => $fileRecord], key("arc-{$fileRecord->id}"))
                                        @endforeach
                                    @endif
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
@script
<script>
    $wire.on('clear-filter', () => {
        $wire.set('searchTerm', '');
        $wire.call('Search');
    });

    document.addEventListener("DOMContentLoaded", function () {
        let activeTab = document.querySelector(".nav-link.active");
        if (activeTab) {
            let tab = new bootstrap.Tab(activeTab);
            tab.show();
        }
    });

</script>
@endscript
