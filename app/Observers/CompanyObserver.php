<?php

namespace App\Observers;

use App\Models\Company;
use App\Services\AuditLogService;

class CompanyObserver
{
    /**
     * Company created.
     */
    public function created(
        Company $company
    ): void {
        app(AuditLogService::class)
            ->record(
                'company.created',
                $company,
                sprintf(
                    'Company created: %s.',
                    $company->name
                ),
                [
                    'company_id' =>
                        $company->id,

                    'name' =>
                        $company->name,

                    'status' =>
                        $company->status,
                ]
            );
    }

    /**
     * Company updated.
     */
    public function updated(
        Company $company
    ): void {
        $changedFields =
            array_values(
                array_intersect(
                    array_keys(
                        $company->getChanges()
                    ),
                    [
                        'name',
                        'address',
                        'contact_person',
                        'contact_number',
                        'email',
                        'status',
                    ]
                )
            );

        if ($changedFields === []) {
            return;
        }

        app(AuditLogService::class)
            ->record(
                'company.updated',
                $company,
                sprintf(
                    'Company updated: %s.',
                    $company->name
                ),
                [
                    'company_id' =>
                        $company->id,

                    'status' =>
                        $company->status,

                    'changed_fields' =>
                        $changedFields,
                ]
            );
    }

    /**
     * Company deleted.
     */
    public function deleted(
        Company $company
    ): void {
        app(AuditLogService::class)
            ->record(
                'company.deleted',
                $company,
                sprintf(
                    'Company deleted: %s.',
                    $company->name
                ),
                [
                    'company_id' =>
                        $company->id,

                    'name' =>
                        $company->name,
                ]
            );
    }
}