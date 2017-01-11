<?php namespace B50\Forums\Core\Auth;

/**
 * Only allow guests
 *
 * @package App\Filters\Forums
 */
class GuestFilter
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filter()
    {
        if (\Auth::check()) {
            return \Redirect::to('/');
        }
    }
}
