<?php namespace B50\Forums\Forums;

/**
 * Move a topic
 *
 * @package App\Forums\TopicMoveService
 */
class ForumTree
{
    /**
     * @param ForumRepoInterface $forum
     */
    public function __construct(ForumRepoInterface $forum)
    {
        $this->forumRepo = $forum;
    }

    /**
     * Generate tree
     */
    public function getTree()
    {
        $forums = $this->forumRepo->getTree();

        // Generate tree
        return $this->generate($forums);
    }

    /**
     * Build forums tree
     *
     * @param array $forums
     * @param null|int $parent
     * @param array $tree
     * @return array
     */
    protected function generate($forums, $parent = null, &$tree = [])
    {
        foreach ($forums as $forum) {
            $isRootParent = ($parent == null and is_numeric($forum->path));
            $isChild = ($parent . '/' . $forum->id == $forum->path);

            // Add to tree and search deeper if we find a child or we're at the top of the tree
            if ($isChild or $isRootParent) {
                // Add to tree
                $tree[$forum->path] = str_repeat(' - ', count($forum->pathExplode()) - 1) . $forum->name;

                // Go deeper
                $this->generate($forums, $forum->path, $tree);
            }

        }

        return $tree;
    }
}
