<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Droplet\Agent\Agent;
use SuperV\Platform\Domains\Droplet\DropletFactory;
use SuperV\Platform\Domains\Feature\Feature;
use SuperV\Platform\Domains\Task\Jobs\DeployTask;
use SuperV\Platform\Domains\Task\TaskBuilder;

class InstallService extends Feature
{
    public static $route = 'any@api/supreme/services/{id}/install';

    public $force = true;

    public function handle(Services $services, TaskBuilder $builder)
    {
        /** @var ServiceModel $service */
        if (! $service = $services->find(request()->route('id'))) {
            throw new \Exception('Service not found');
        }

        /** @var Agent $agent */
        $agent = new Agent($service->getAgent()->toArray());

        $task = $builder->setTitle("Install ".$service->getName())->setPayload([
            'server_id' => $service->getServerId(),
            'feature'   => $agent->getFeature('install'),
        ])->build();

        $this->dispatch(new DeployTask($task));

//        $this->dispatch(new Deployer(new Task($taskModel)));

        //        if (!$this->force && $remote->config("{$agent->identifier()}.installed")) {
        //            throw new \Exception('Already installed');
        //        }

        //        if ($result) {
        //            $remote->config("{$this->service->getAgent()->identifier()}.installed", true);
        //        }
    }
}