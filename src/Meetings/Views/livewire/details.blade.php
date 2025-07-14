 <div class="card-body" style="padding: 20px;">
     <ul class="list-unstyled my-3 py-1">
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-calendar-event" style="font-size: 1.5rem; color: #ffc107;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Meeting Name') }}:</span>
             <span style="color: #555;">{{ $meeting->meeting_name ?? 'N/A' }}</span>
         </li>

         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-calendar" style="font-size: 1.5rem; color: #007bff;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Fiscal Year') }}:</span>
             <span style="color: #555;">{{ $meeting->fiscalYear?->year ?? 'N/A' }} </span>
         </li>
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-layer" style="font-size: 1.5rem; color: #28a745;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Committee') }}:</span>
             <span style="color: #555;">{{ $meeting->committee?->committee_name ?? 'N/A' }}</span>
         </li>

         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-repeat" style="font-size: 1.5rem; color: #dc3545;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Recurrence') }}:</span>
             <span style="color: #555;">{{ $meeting->recurrence ?? 'N/A' }}</span>
         </li>
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-time" style="font-size: 1.5rem; color: #6c757d;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Start Date') }}:</span>
             <span style="color: #555;">{{ $meeting->start_date ?? 'N/A' }}</span>
         </li>
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-time-five" style="font-size: 1.5rem; color: #28a745;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('End Date') }}:</span>
             <span style="color: #555;">{{ $meeting->end_date ?? 'N/A' }}</span>
         </li>
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-calendar-alt" style="font-size: 1.5rem; color: #ffc107;"></i>
             <span class="fw-medium mx-2"
                 style="color: #333; font-weight: 500;">{{ __('Recurrence End Date') }}:</span>
             <span style="color: #555;">{{ $meeting->recurrence_end_date ?? 'N/A' }}</span>
         </li>
         <li class="d-flex align-items-center mb-4">
             <i class="bx bx-file" style="font-size: 1.5em; color: #8593e4;"></i>
             <span class="fw-medium mx-2" style="color: #333; font-weight: 500;">{{ __('Description') }}:</span>
             <span style="color: #555;">{{ $meeting->description ?? 'N/A' }}</span>
         </li>
     </ul>
 </div>
