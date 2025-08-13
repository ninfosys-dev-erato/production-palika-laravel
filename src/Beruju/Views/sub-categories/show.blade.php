<x-layout.app header="{{ __('beruju::beruju.view_sub_category') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.beruju.index') }}">{{ __('beruju::beruju.beruju_management') }}</a>
            <li class="breadcrumb-item"><a href="{{ route('admin.beruju.sub-categories.index') }}">{{ __('beruju::beruju.sub_categories') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('beruju::beruju.view') }}</li>
        </ol>
    </nav>
    
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">{{ __('beruju::beruju.sub_category_details') }}</h5>
                    <div>
                        <a href="{{ route('admin.beruju.sub-categories.edit', $subCategory->id) }}" class="btn btn-warning">
                            <i class="bx bx-edit"></i> {{ __('beruju::beruju.edit') }}
                        </a>
                        <a href="{{ route('admin.beruju.sub-categories.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> {{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">{{ __('beruju::beruju.name') }}:</th>
                                    <td><strong>{{ $subCategory->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.slug') }}:</th>
                                    <td><code>{{ $subCategory->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.parent_category') }}:</th>
                                    <td>
                                        @if($subCategory->parent)
                                            <span class="badge bg-info">{{ $subCategory->parent->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('beruju::beruju.root_category') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.remarks') }}:</th>
                                    <td>{{ $subCategory->remarks ?: __('beruju::beruju.no_remarks') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">{{ __('beruju::beruju.created_by') }}:</th>
                                    <td>{{ $subCategory->creator->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.created_at') }}:</th>
                                    <td>{{ $subCategory->created_at ? $subCategory->created_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.updated_by') }}:</th>
                                    <td>{{ $subCategory->updater->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('beruju::beruju.updated_at') }}:</th>
                                    <td>{{ $subCategory->updated_at ? $subCategory->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($subCategory->children->count() > 0)
                        <div class="mt-4">
                            <h6 class="text-primary">{{ __('beruju::beruju.child_categories') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('beruju::beruju.name') }}</th>
                                            <th>{{ __('beruju::beruju.slug') }}</th>
                                            <th>{{ __('beruju::beruju.created_at') }}</th>
                                            <th>{{ __('beruju::beruju.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subCategory->children as $child)
                                            <tr>
                                                <td>{{ $child->name }}</td>
                                                <td><code>{{ $child->slug }}</code></td>
                                                <td>{{ $child->created_at ? $child->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.beruju.sub-categories.show', $child->id) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.beruju.sub-categories.edit', $child->id) }}" 
                                                       class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
