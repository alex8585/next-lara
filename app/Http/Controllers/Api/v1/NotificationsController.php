<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use App\Http\Requests\StoreNotificationRequest;

class NotificationsController extends Controller
{
    private $notifRepo;

    public function __construct(NotificationRepository $notifRepo)
    {
        $this->notifRepo = $notifRepo;
        /* $this->authorizeResource(Notification::class, 'tag'); */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = min(100, (int) request()->get('perPage', 5));

        if ($perPage > -1) {
            return $this->notifRepo->paginate($perPage);
        }

        return $this->notifRepo->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        $validated = $request->safe();
        $validated['symbol_id'] = $request->safe()->symbol['value'];
        $validated['direction'] = $request->safe()->direction['value'];

        $notif = $this->notifRepo->create($validated->all());

        return response()->json([
            'message' => 'Notification created successfully!',
            'id' => $notif->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $tag)
    {
        return new NotificationResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNotificationRequest $request, Notification $notification)
    {
        /* $data = $this->formatLocalesFields($request->validated()); */

        $validated = $request->safe();
        $validated['symbol_id'] = $request->safe()->symbol['value'];
        $validated['direction'] = $request->safe()->direction['value'];

        $this->notifRepo->update($notification, $validated->all());

        return response()->json([
            'message' => 'Notification updated successfully!',
            'id' => $notification->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $this->notifRepo->delete($notification);

        return response()->json([
            'message' => 'Notification deleted successfully!',
            'id' => $notification->id,
        ]);
    }

    //
}
