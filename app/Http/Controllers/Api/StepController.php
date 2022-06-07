<?php

namespace App\Http\Controllers\Api;

use App\Models\Step;
use App\Models\User;
use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StepResource;

class StepController extends Controller
{
    public function store(Snippet $snippet, Request $request)
    {
        $this->authorize('storeStep', $snippet);

        $this->validate($request, [
            'title' => 'nullable|max:255',
            'body'=>'nullable|string'
        ]);

        $step = $snippet->steps()->create([
            'title'=>$request->title,
            'body'=>$request->body ?? null,
            'order'=>$snippet->steps()->count() > 0 ? $this->getOrder($request):1,
        ]);

        return new StepResource($step);
    }

    public function update(Snippet $snippet, Step $step, Request $request)
    {
        $this->authorize('update', $step);

        $this->validate($request, [
            'title' => 'nullable|max:255',
            'body'=>'nullable|string'
        ]);

        return $step->update([
            'title'=>$request->title,
            'body'=>$request->body ?? null,
        ]);
    }

    protected function getOrder(Request $request)
    {
        if ($request->before or $request->after) {
            $order= Step::where('id', $request->before)
            ->orWhere('id', $request->after)
            ->first()
            ->{($request->before ? 'before' : 'after') . 'Order'}();

            return $order;
        }
        return 1;
    }

    public function destroy(Snippet $snippet, Step $step)
    {
        $this->authorize('destroy', $step);

        if ($snippet->steps->count() === 1) {
            return response(null, 400);
        }

        $step->delete();
    }
}
