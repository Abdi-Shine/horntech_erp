<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $category
 * @property string $type
 * @property string|null $bank_name
 * @property string|null $branch_name
 * @property string|null $account_number
 * @property string|null $iban
 * @property string|null $swift_code
 * @property string $currency
 * @property int|null $branch_id
 * @property int|null $parent_id
 * @property numeric $balance
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalItem> $journalItems
 * @property-read int|null $journal_items_count
 * @property-read Account|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereSwiftCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property int|null $branch_id
 * @property string $module
 * @property string $action
 * @property string|null $description
 * @property string|null $record_type
 * @property int|null $record_id
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property string|null $device
 * @property string|null $mac
 * @property string|null $os
 * @property string|null $browser
 * @property string|null $isp
 * @property string|null $city
 * @property string|null $country
 * @property string|null $user_agent
 * @property string|null $url
 * @property string|null $method
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIsp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereMac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereRecordType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserId($value)
 * @mixin \Eloquent
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property string $path
 * @property string|null $size
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Backup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Backup extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 * @property string $level
 * @property string|null $bank_name
 * @property string|null $account_name
 * @property string|null $manager_name
 * @property string|null $manager_phone
 * @property string|null $address
 * @property string|null $district
 * @property string|null $region
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Store> $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereManagerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereManagerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property string|null $icon_class
 * @property string|null $icon_color
 * @property int|null $parent_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIconClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIconColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $business_type
 * @property string|null $legal_form
 * @property string|null $registration_number
 * @property string|null $vat_number
 * @property string|null $logo
 * @property string|null $establishing_year
 * @property string|null $registered_office
 * @property string|null $address
 * @property string|null $country
 * @property string|null $city
 * @property string|null $region
 * @property string|null $postal_box
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $mobile_number
 * @property string|null $email
 * @property string|null $website
 * @property string|null $facebook_page
 * @property string|null $whatsapp_number
 * @property numeric $total_share_capital
 * @property numeric $par_value
 * @property string $currency
 * @property string|null $tagline
 * @property string|null $tax_id
 * @property string|null $license_number
 * @property string|null $industry
 * @property int|null $employee_count
 * @property string|null $base_currency
 * @property string|null $exchange_rate_method
 * @property int $auto_exchange_rate
 * @property string|null $fiscal_year_start
 * @property string|null $fiscal_year_end
 * @property string|null $default_payment_method
 * @property string|null $default_bank_account
 * @property int $multiple_payment_methods
 * @property numeric $max_discount_percent
 * @property string|null $rounding_method
 * @property int $enable_discount
 * @property int $round_invoice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branches
 * @property-read int|null $branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shareholder> $shareholders
 * @property-read int|null $shareholders_count
 * @property-read \App\Models\Subscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAutoExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBaseCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDefaultBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDefaultPaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmployeeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEnableDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEstablishingYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereExchangeRateMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFacebookPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFiscalYearEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFiscalYearStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLegalForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMaxDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMultiplePaymentMethods($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereParValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalBox($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegisteredOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRoundInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRoundingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTotalShareCapital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWhatsappNumber($value)
 * @mixin \Eloquent
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $customer_code
 * @property string $customer_type
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $account_id
 * @property string|null $account_type
 * @property string|null $account_code
 * @property string $opening_balance_type
 * @property numeric|null $credit_limit
 * @property numeric $amount_balance
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentIn> $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAmountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreditLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereOpeningBalanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $user_id
 * @property string $employee_id
 * @property string|null $national_id
 * @property string|null $title
 * @property string $full_name
 * @property string|null $photo
 * @property string|null $email
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $marital_status
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $district
 * @property string|null $city
 * @property string|null $country
 * @property string|null $designation
 * @property string|null $department
 * @property string|null $branch
 * @property string|null $store
 * @property string|null $company
 * @property numeric|null $salary
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUserId($value)
 * @mixin \Eloquent
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $expense_account_id
 * @property int|null $bank_account_id
 * @property int|null $branch_id
 * @property int|null $supplier_id
 * @property string $expense_name
 * @property string|null $description
 * @property string|null $reference_no
 * @property string|null $payment_method
 * @property numeric $amount
 * @property string|null $expense_date
 * @property string $status
 * @property string|null $receipt
 * @property int|null $created_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereExpenseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $entry_number
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $reference
 * @property string|null $description
 * @property string $status
 * @property numeric $total_amount
 * @property int|null $branch_id
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereEntryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JournalEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $journal_entry_id
 * @property int $account_id
 * @property string|null $description
 * @property numeric $debit
 * @property numeric $credit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Account $account
 * @property-read \App\Models\JournalEntry $entry
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereJournalEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JournalItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $receipt_no
 * @property string $payment_date
 * @property int $customer_id
 * @property int|null $bank_account_id
 * @property string|null $invoice_no
 * @property string $payment_method
 * @property numeric $amount
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read User|null $creator
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentIn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PaymentIn extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $product_code
 * @property string $product_name
 * @property int|null $category_id
 * @property string $unit
 * @property numeric $purchase_price
 * @property numeric $selling_price
 * @property string|null $account_code
 * @property int $low_stock_threshold
 * @property string|null $image
 * @property string|null $description
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseBillItem> $purchaseBillItems
 * @property-read int|null $purchase_bill_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $stocks
 * @property-read int|null $stocks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLowStockThreshold($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int|null $branch_id
 * @property int|null $store_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductStock extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $bill_number
 * @property string|null $supplier_invoice_no
 * @property int $supplier_id
 * @property int|null $payment_account_id
 * @property int|null $branch_id
 * @property int|null $store_id
 * @property string $bill_date
 * @property string|null $due_date
 * @property string|null $payment_terms
 * @property numeric $subtotal
 * @property numeric $vat
 * @property numeric $total_amount
 * @property numeric $paid_amount
 * @property numeric $balance_amount
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseBillItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPaymentDetail> $paymentDetails
 * @property-read int|null $payment_details_count
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBillDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaymentAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereSupplierInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBill whereVat($value)
 * @mixin \Eloquent
 */
	class PurchaseBill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_bill_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string|null $product_code
 * @property numeric $quantity
 * @property string|null $unit
 * @property numeric $unit_price
 * @property numeric $discount
 * @property numeric $total_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseReturnItem> $returnItems
 * @property-read int|null $return_items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseBillItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PurchaseBillItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int $purchase_id
 * @property int $expense_account_id
 * @property string $expense_name
 * @property string|null $description
 * @property numeric $amount
 * @property int|null $supplier_id
 * @property int|null $branch_id
 * @property int|null $bank_account_id
 * @property string|null $expense_date
 * @property int|null $created_by
 * @property int|null $approved_by
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\PurchaseBill $purchase
 * @property-read \App\Models\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereExpenseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseExpense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PurchaseExpense extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $po_number
 * @property int $supplier_id
 * @property int|null $branch_id
 * @property int|null $store_id
 * @property string $order_date
 * @property string|null $expected_delivery
 * @property string|null $payment_terms
 * @property numeric $subtotal
 * @property numeric $vat
 * @property numeric $total_amount
 * @property string|null $notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseOrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereExpectedDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereVat($value)
 * @mixin \Eloquent
 */
	class PurchaseOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_order_id
 * @property int $product_id
 * @property numeric $quantity
 * @property string|null $unit
 * @property numeric $unit_price
 * @property numeric $total_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseOrder $purchaseOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PurchaseOrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $return_number
 * @property int $purchase_bill_id
 * @property int $supplier_id
 * @property int $branch_id
 * @property int|null $store_id
 * @property string $return_date
 * @property string|null $reason
 * @property numeric $subtotal
 * @property numeric $tax
 * @property numeric $total_amount
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\Branch $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseReturnItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\Supplier $supplier
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PurchaseReturn extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_return_id
 * @property int $purchase_bill_item_id
 * @property int $product_id
 * @property numeric $quantity
 * @property numeric $unit_price
 * @property numeric $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseReturn $purchaseReturn
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem wherePurchaseBillItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem wherePurchaseReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PurchaseReturnItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property array<array-key, mixed>|null $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $invoice_no
 * @property \Illuminate\Support\Carbon $invoice_date
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property int|null $customer_id
 * @property int|null $branch_id
 * @property int|null $store_id
 * @property numeric $subtotal
 * @property numeric $discount
 * @property numeric $tax
 * @property numeric $total_amount
 * @property numeric $paid_amount
 * @property numeric $due_amount
 * @property string $payment_method
 * @property int|null $payment_account_id
 * @property string $status
 * @property string|null $notes
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SalesOrderItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder wherePaymentAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SalesOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $sales_order_id
 * @property int|null $product_id
 * @property string $product_name
 * @property string|null $product_code
 * @property numeric $unit_price
 * @property numeric $quantity
 * @property string $unit
 * @property numeric $discount
 * @property numeric $total_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SalesOrder $order
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereSalesOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesOrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SalesOrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property numeric $share_amount
 * @property numeric $ownership_percentage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereOwnershipPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereShareAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shareholder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Shareholder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property int $branch_id
 * @property int|null $store_id
 * @property numeric $quantity
 * @property string $type
 * @property int|null $reference_id
 * @property string|null $reference_type
 * @property numeric $balance_after
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Product $product
 * @property-read Model|\Eloquent|null $reference
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereBalanceAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereReferenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class StockMovement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int $branch_id
 * @property string $name
 * @property string $code
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 * @property int $staff_count
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereStaffCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $transfer_no
 * @property string $type
 * @property int $product_id
 * @property int $from_store_id
 * @property int $to_store_id
 * @property int $quantity
 * @property string $status
 * @property int $requested_by
 * @property int|null $approved_by
 * @property string|null $remarks
 * @property string|null $approved_at
 * @property string|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $company_id
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Store $fromStore
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $requester
 * @property-read \App\Models\Store $toStore
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereFromStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereToStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereTransferNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StoreTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class StoreTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property int $subscription_plan_id
 * @property string $start_date
 * @property string $expiry_date
 * @property string $status
 * @property string|null $payment_method
 * @property int $auto_renew
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubscriptionPayment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\SubscriptionPlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereAutoRenew($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereSubscriptionPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $subscription_id
 * @property numeric $amount
 * @property string $payment_date
 * @property string $payment_method
 * @property string|null $transaction_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subscription $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SubscriptionPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property numeric $price
 * @property string $billing_cycle
 * @property int $max_users
 * @property int $storage_limit_gb
 * @property array<array-key, mixed>|null $features
 * @property string $status
 * @property bool $is_popular
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereBillingCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereIsPopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereMaxUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereStorageLimitGb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SubscriptionPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $supplier_code
 * @property string $supplier_type
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $account_id
 * @property string|null $account_type
 * @property string|null $account_code
 * @property string $opening_balance_type
 * @property numeric $amount_balance
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseBill> $purchaseBills
 * @property-read int|null $purchase_bills_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPayment> $supplierPayments
 * @property-read int|null $supplier_payments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAmountBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereOpeningBalanceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSupplierType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $voucher_no
 * @property string $payment_date
 * @property int $supplier_id
 * @property int|null $bank_account_id
 * @property string $payment_method
 * @property numeric $amount
 * @property string|null $reference
 * @property string|null $notes
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account|null $bankAccount
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SupplierPaymentDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPayment whereVoucherNo($value)
 * @mixin \Eloquent
 */
	class SupplierPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $supplier_payment_id
 * @property int $purchase_bill_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseBill $bill
 * @property-read \App\Models\SupplierPayment $payment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail wherePurchaseBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereSupplierPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupplierPaymentDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SupplierPaymentDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string|null $fullname
 * @property string|null $username
 * @property string $email
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $photo
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

