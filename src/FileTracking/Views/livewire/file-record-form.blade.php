<form wire:submit.prevent="save">
    <div class="flex-grow-1 container-p-y">
        <div class="row g-6">
            <div class="col-md-12">
                <div class="row flex-column mt-4">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="btn-toolbar demo-inline-spacing" role="toolbar" aria-label="Toolbar with button groups">
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
                            <label for="">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-success" type="button" id="button-addon2"><i class="bx bx-search-alt"></i></button>
                            </div>
                        </div>
                        <div class="right-side-menu d-flex align-items-center gap-2">
                            <div class="text-center text-md-right text-muted">
                                <span>Showing</span>
                                <strong>{{$offset +  1 }}</strong>
                                <span>to</span>
                                <strong>{{count($fileRecords)}}</strong>
                                <span>of</span>
                                <strong>{{$total}}</strong>
                            </div>
                            <div class="demo-inline-spacing">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item first">
                                            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left bx-sm"></i></a>
                                        </li>
                                        <li class="page-item last">
                                            <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right bx-sm"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                                <!--/ Basic Pagination -->
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
    <div class="nav-align-top mb-6">
        <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
            <li class="nav-item mb-1 mb-sm-0" role="presentation">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
                          <span class="d-none d-sm-block"><i class="tf-icons bx bx-copy-alt bx-sm me-1_5 align-text-bottom"></i> All Letters
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1_5 pt-50">3</span></span><i class="bx bx-home bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item mb-1 mb-sm-0" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false" tabindex="-1">
                    <span class="d-none d-sm-block"><i class="tf-icons bx bx-user bx-sm me-1_5 align-text-bottom"></i> Profile</span><i class="bx bx-user bx-sm d-sm-none"></i>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false" tabindex="-1">
                    <span class="d-none d-sm-block"><i class="tf-icons bx bx-message-square bx-sm me-1_5 align-text-bottom"></i> Messages</span><i class="bx bx-message-square bx-sm d-sm-none"></i>
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <table class="table card-table">
                    <tbody class="table-border-bottom-0">
                    @foreach($fileRecords as $fileRecord)
                        <tr class="table-active">
                            <td>
                                <div class="checkbox-container">
                                    <input class="form-check-input" type="checkbox" value="">
                                    <div class="form-check-custom">
                                        <input class="custom-checkbox" type="checkbox" id="customCheckbox">
                                        <label class="custom-checkbox-label" for="customCheckbox">
                                            <i class="bx bx-star bx-sm"></i>
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img
                                            src="https://media2.dev.to/dynamic/image/width=800%2Cheight=%2Cfit=scale-down%2Cgravity=auto%2Cformat=auto/https%3A%2F%2Fwww.gravatar.com%2Favatar%2F2c7d99fe281ecd3bcd65ab915bac6dd5%3Fs%3D250"
                                            class="rounded-circle img-thumbnail avatar-sm"
                                            alt="User Avatar"
                                    >
                                    <span>{{$fileRecord->applicant_name}} | {{$fileRecord->applicant_mobile_no}}</span>
                                </div>
                            </td>
                            <td> @if(!empty($fileRecord->reg_no)){!! "<strong>#".$fileRecord->reg_no."</strong>| "  !!} @endif<span>{{$fileRecord->title}}</span></td>
                            <td><span class="badge bg-label-primary me-1">{{$fileRecord->created_at->diffForHumans()}}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                <p>
                    Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                    cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                    cheesecake fruitcake.
                </p>
                <p class="mb-0">
                    Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                    cotton candy liquorice caramels.
                </p>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                <p>
                    Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                    cupcake gummi bears cake chocolate.
                </p>
                <p class="mb-0">
                    Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                    roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                    jelly-o tart brownie jelly.
                </p>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</form>
