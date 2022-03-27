<?php

trait SecureDelete
{
    /**
     * Delete only when there is no reference to other models.
     *
     * @param array $relations
     * @return response
     */
    public function secureDelete(String ...$relations)
    {
        $hasRelation = false;
        foreach ($relations as $relation) {
            if ($this->$relation()->withTrashed()->count()) {
                $hasRelation = true;
                break;
            }
        }

        if ($hasRelation) {
            return false;
        } else {
            $this->delete();
        }
        return true;
    }
}
