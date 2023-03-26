<?php

namespace App\Services\Merchants;

use App\Constants\ErrorCodes;
use App\Exceptions\Custom\FrontEndException;
use App\Http\Data\Api\Merchants\EditData;
use App\Models\Merchants\Merchant;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CrudService
{
    /**
     * @param EditData $data
     * @param Authenticatable $blameable
     * @return Merchant
     * @throws FrontEndException
     */
    public function create(EditData $data, Authenticatable $blameable): Merchant
    {
        $merchant = new Merchant();
        $merchant->fill(
            array_merge(
                ['id' => $data->merchant_id],
                $data->all()
            )
        );
        $merchant->setBlameables($blameable->id);
        $this->save($merchant);

        return $merchant;
    }

    /**
     * @param EditData $data
     * @param Merchant $merchant
     * @param User $updater
     * @return Merchant
     * @throws FrontEndException
     */
    public function edit(EditData $data, Merchant $merchant, Authenticatable $updater): Merchant
    {
        $this->guardSameId($data->merchant_id, $merchant->id);

        $merchant->fill($data->toArray());
        $merchant->setUpdater($updater->id);
        $this->save($merchant);

        return $merchant;
    }

    /**
     * @param Merchant $merchant
     * @return void
     * @throws FrontEndException
     */
    public function destroy(Merchant $merchant): void
    {
        $this->guardDeletion($merchant);

        $this->delete($merchant);
    }

    /**
     * @param int|null $merchant_id
     * @param int $id
     * @return void
     * @throws FrontEndException
     */
    private function guardSameId(?int $merchant_id, int $id): void
    {
        if (empty($merchant_id)) {
            return;
        }

        if ($merchant_id != $id) {
            throw new FrontEndException(
                message: __("The id in the request and in the url are not the same"),
                code: ErrorCodes::EDIT_ID_NOT_SAME,
            );
        }
    }

    /**
     * @throws FrontEndException
     */
    private function guardDeletion(Merchant $merchant): void
    {
        if (!$merchant->isDeletable()) {
            throw new FrontEndException(
                message: __("Merchant is not in deletable state"),
                code: ErrorCodes::MODEL_CANNOT_BE_DELETED
            );
        }
    }

    /**
     * @param Model $merchant
     * @return void
     * @throws FrontEndException
     */
    private function save(Model $merchant): void
    {
        if (!$merchant->save()) {
            throw new FrontEndException(
                message: __("Error while saving the record"),
                code: ErrorCodes::ERROR_WHILE_SAVING,
            );
        }
    }

    /**
     * @param Merchant $merchant
     * @return void
     * @throws FrontEndException
     */
    private function delete(Merchant $merchant): void
    {
        if (!$merchant->delete()) {
            throw new FrontEndException(
                message: __("Error while deleting the record"),
                code: ErrorCodes::ERROR_WHILE_DELETING,
            );
        }
    }
}
