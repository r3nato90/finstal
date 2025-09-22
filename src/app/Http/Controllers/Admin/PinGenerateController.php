<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PinGenerate;
use App\Models\User;
use App\Services\PinGenerateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PinGenerateController extends Controller
{
    public PinGenerateService $pinGenerateService;

    public function __construct(PinGenerateService $pinGenerateService)
    {
        $this->pinGenerateService = $pinGenerateService;
    }

    /**
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): View
    {
        $setTitle = __('Pin Management');

        $search = request()->get('search');
        $status = request()->get('status');
        $pinType = request()->get('pin_type');
        $setUser = request()->get('set_user');
        $sortField = request()->get('sort_field', 'created_at');
        $sortDirection = request()->get('sort_direction', 'desc');

        $query = PinGenerate::with(['user', 'setUser']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                    ->orWhere('pin_number', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('fullname', 'like', "%{$search}%");
                    })
                    ->orWhereHas('setUser', function ($setUserQuery) use ($search) {
                        $setUserQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('fullname', 'like', "%{$search}%");
                    });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($pinType === 'admin') {
            $query->admins();
        } elseif ($pinType === 'user') {
            $query->users();
        }

        if ($setUser) {
            $query->where('set_user_id', $setUser);
        }

        $allowedSortFields = ['uid', 'pin_number', 'amount', 'charge', 'status', 'created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
        } else {
            $query->latest();
        }

        $perPage = (int) request()->get('per_page', 20);
        $pins = $query->paginate($perPage)->appends(request()->all());

        $setUsers = User::select('id', 'email', 'first_name', 'last_name')
            ->whereIn('id', PinGenerate::whereNotNull('set_user_id')->distinct()->pluck('set_user_id'))
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->email . ' (' . $user->fullname . ')'];
            });

        $stats = $this->getPinStats();

        $filters = [
            'search' => $search,
            'status' => $status,
            'pin_type' => $pinType,
            'set_user' => $setUser,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ];

        return view('admin.pin.index', compact(
            'pins',
            'setUsers',
            'stats',
            'filters',
            'setTitle'
        ));
    }

    /**
     * Get pin statistics
     */
    private function getPinStats(): array
    {
        return [
            'totalPins' => PinGenerate::count(),
            'unusedPins' => PinGenerate::unused()->count(),
            'usedPins' => PinGenerate::utilized()->count(),
            'adminPins' => PinGenerate::admins()->count(),
            'userPins' => PinGenerate::users()->count(),
            'totalPinAmount' => PinGenerate::sum('amount'),
            'totalCharges' => PinGenerate::sum('charge'),
            'usedPinAmount' => PinGenerate::utilized()->sum('amount'),
            'unusedPinAmount' => PinGenerate::unused()->sum('amount'),
        ];
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required','numeric','gt:0'],
            'number' => ['required','integer','gt:0']
        ]);

        $this->pinGenerateService->save($this->pinGenerateService->prepParams($request->integer('number'), $request->input('amount'), 0, "Created by a system administrator"));
        return back()->with('notify', [['success', __('admin.pin.notify.create.success')]]);
    }

}
