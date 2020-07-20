<?php

namespace Cmgmyr\Messenger\Traits;

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Models;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Builder;

trait Messagable
{
    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function messages()
    {
        return $this->hasMany(Models::classname(Message::class));
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function participants()
    {
        return $this->hasMany(Models::classname(Participant::class));
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @codeCoverageIgnore
     */
    public function threads()
    {
        return $this->belongsToMany(
            Models::classname(Thread::class),
            Models::table('participants'),
            'user_id',
            'thread_id'
        );
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newThreadsCount()
    {
        return $this->threadsWithNewMessages()->count();
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function unreadMessagesCount()
    {
        return Message::unreadForUser($this->getKey())->count();
    }

    /**
     * Returns all threads with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->whereNull(Models::table('participants') . '.last_read');
                $q->orWhere(Models::table('threads') . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . Models::table('participants') . '.last_read'));
            })->get();
    }

    /**
     * Returns the archived threads count for user.
     *
     * @return int
     */
    public function archivedThreadsCount()
    {
        return $this->archivedThreads()->count();
    }

    /**
     * Returns all archived threads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function archivedThreads()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->where(Models::table('participants') . '.archived', true);
            })->get();
    }

    /**
     * Returns the starred threads count for user.
     *
     * @return int
     */
    public function starredThreadsCount()
    {
        return $this->starredThreads()->count();
    }

    /**
     * Returns all starred threads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function starredThreads()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->where(Models::table('participants') . '.starred', true);
            })->get();
    }

    /**
     * Returns the trashed threads count for user.
     *
     * @return int
     */
    public function trashedThreadsCount()
    {
        return $this->trashedThreads()->count();
    }

    /**
     * Returns all trashed threads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function trashedThreads()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->whereNotNull(Models::table('participants') . '.deleted_at');
            })->get();
    }

}
