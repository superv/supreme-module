<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Platform\Domains\Droplet\Model\DropletModel;

class ServiceModel extends ServiceEntryModel
{
    public function agent()
    {
        return $this->hasOne(DropletModel::class, 'id', 'agent_id');
    }

    /** @return DropletModel */
    public function getAgent()
    {
        return $this->agent;
    }

    public function server()
    {
        return $this->hasOne(ServerModel::class, 'id', 'server_id');
    }

    /** @return ServerModel */
    public function getServer()
    {
        return $this->server;
    }
}