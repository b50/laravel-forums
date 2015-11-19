<?php namespace Kaamaru\Forums\Core\Flash;

/**
 * Show flash messages
 *
 * @package Kaamaru\Forums\Core\Flash
 */
class Flash
{
    /**
     * Show success flash
     *
     * @param string $message
     * @param null|string $location
     * @return void
     */
    public function success($message, $location = null)
    {
        $this->message($message, 'success', $location);
    }

    /**
     * Show success flash
     *
     * @param string $message
     * @param null|string $location
     * @return void
     */
    public function warning($message, $location = null)
    {
        $this->message($message, 'warning', $location);
    }

    /**
     * Show success flash
     *
     * @param string $message
     * @param null|string $location
     * @return void
     */
    public function danger($message, $location = null)
    {
        $this->message($message, 'danger', $location);
    }

    /**
     * Show flash message
     *
     * @param string $message
     * @param string $status
     * @param null|string $location
     * @return void
     */
    public function message($message, $status, $location = null)
    {
        \Session::flash('message', $message);
        \Session::flash('message_status', $status);

        if ($location) {
            \Session::flash('message_location', $location);
        }
    }
}
