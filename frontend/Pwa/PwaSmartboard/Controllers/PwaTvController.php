<?php

namespace Frontend\Pwa\PwaSmartboard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\Program;
use Src\Employees\Models\Employee;

class PwaTvController extends Controller
{
    public Collection $citizenharters; // Type binding for collections
    public Collection $employees;
    public Collection $representatives;
    public Collection $programs;
    public Collection $videos;
    public Collection $notices;
    public int $ward;

    public function index($ward = 0)  // Remove type hint to allow string input
    {
        $ward = (int) $ward; // Cast to integer

        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();
        // Fetch Employees with optional ward filter and ordered by position
        $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
            ->with('designation')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->orderBy('position')
            ->get();

        // Fetch Programs
        $this->programs = Program::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();

        // Pass all data to the view
        return view('Pwa.PwaSmartboard::index', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'employees' => $this->employees,
            'programs' => $this->programs,
            'notices' => $this->notices,
        ]);
    }

    public function notices($ward = 0)  // Remove type hint to allow string input
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;

        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();

        return view('Pwa.PwaSmartboard::notices', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'notices' => $this->notices,
        ]);
    }
    public function programs($ward = 0)  // Remove type hint to allow string input
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;
        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Employees with optional ward filter and ordered by position
        $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
            ->with('designation')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->orderBy('position')
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();
        return view('Pwa.PwaSmartboard::programs', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'employees' => $this->employees,
            'notices' => $this->notices,
        ]);
    }
    public function videos($ward = 0)  // Remove type hint to allow string input
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;
        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Employees with optional ward filter and ordered by position
        $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
            ->with('designation')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->orderBy('position')
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();
        return view('Pwa.PwaSmartboard::videos', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'employees' => $this->employees,
            'notices' => $this->notices,
        ]);
    }

    public function representatives($ward = 0)  // Remove type hint to allow string input
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;
        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Employees with optional ward filter and ordered by position
        $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
            ->with('designation')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->orderBy('position')
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();
        return view('Pwa.PwaSmartboard::representatives', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'employees' => $this->employees,
            'notices' => $this->notices,
        ]);
    }
    public function employees($ward = 0)  // Remove type hint to allow string input
    {
        $previousUrl = url()->previous();
        $path = explode('/', parse_url($previousUrl, PHP_URL_PATH));
        $wardNum = end($path);
        $ward = is_numeric($wardNum) ? (int) $wardNum : 0;
        // Fetch Citizen Charters with optional ward filter
        $this->citizenharters = CitizenCharter::where('can_show_on_admin', true)
            ->whereNull(['deleted_at', 'deleted_by'])
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->get();

        // Fetch Employees with optional ward filter and ordered by position
        $this->employees = Employee::whereNull(['deleted_at', 'deleted_by'])
            ->with('designation')
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->where('ward_no', $ward);
            })
            ->orderBy('position')
            ->get();

        // Fetch Notices (latest 4)
        $this->notices = Notice::where('can_show_on_admin', true)
            ->when($ward > 0, function ($query) use ($ward) {
                return $query->whereHas('wards', function ($q) use ($ward) {
                    $q->where('ward', $ward);
                });
            })
            ->whereNull(['deleted_at', 'deleted_by'])
            ->latest()
            ->take(4)
            ->get();
        return view('Pwa.PwaSmartboard::employees', [
            'ward' => $ward,
            'citizenharters' => $this->citizenharters,
            'employees' => $this->employees,
            'notices' => $this->notices,
        ]);
    }
}