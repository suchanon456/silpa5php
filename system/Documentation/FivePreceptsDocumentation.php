<?php
/**
 * Silpa5PHP Framework - Five Precepts System Documentation
 * 
 * @package     Silpa5PHP
 * @subpackage  Documentation
 * @category    Five Precepts
 * @author      Silpa5PHP Team
 * @license     MIT License
 */

namespace System\Documentation;

/**
 * FivePreceptsDocumentation - Complete guide for the Five Precepts System
 * 
 * ================================================================================
 * TABLE OF CONTENTS
 * ================================================================================
 * 
 * 1. Overview
 * 2. Architecture
 * 3. The Five Precepts
 * 4. Usage Examples
 * 5. Integration with Framework
 * 6. Best Practices
 * 7. API Reference
 * 
 * ================================================================================
 * 1. OVERVIEW
 * ================================================================================
 * 
 * The Five Precepts (Panca Sila) system is a core security and governance
 * framework for Silpa5PHP. It implements Buddhist ethical principles to ensure
 * the framework operates with integrity, mindfulness, and compassion.
 * 
 * The Five Precepts are:
 * - Ahimsa (ไม่ทำลาย): Do not harm or destroy
 * - Adinnadana (ไม่ลัก): Do not steal or take what is not given
 * - Kamesu (ไม่ละเมิด): Do not abuse or violate
 * - Musavada (ไม่พูดเท็จ): Do not lie or falsify
 * - Sati (มีสติ): Be mindful and aware
 * 
 * ================================================================================
 * 2. ARCHITECTURE
 * ================================================================================
 * 
 * The system consists of:
 * 
 * a) BasePrecept (Abstract Base Class)
 *    - Provides common functionality for all precepts
 *    - Handles violation/blessing logging
 *    - Manages precept linking
 *    - Tracks adherence statistics
 * 
 * b) Individual Precept Classes
 *    - AhimsaPrecept: Protects resources and prevents destruction
 *    - Adinnadana: Manages ownership and access control
 *    - Kamesu: Enforces consent and respect
 *    - Musavada: Ensures data integrity and truthfulness
 *    - Sati: Monitors system mindfulness
 * 
 * c) FivePreceptsManager
 *    - Orchestrates all precepts
 *    - Performs cross-validation
 *    - Generates health and compliance reports
 * 
 * d) Exceptions
 *    - PreceptViolationException: Thrown when a precept is violated
 *    - KarmaException: Tracks consequences of actions
 *    - CompassionateException: Provides helpful error messages
 * 
 * ================================================================================
 * 3. THE FIVE PRECEPTS IN DETAIL
 * ================================================================================
 * 
 * 3.1 AHIMSA (ไม่ทำลาย) - Prevent Harm
 * -----------------------------------
 * 
 * Purpose: Protect system resources and data from destruction or corruption
 * 
 * Key Functions:
 * - protectResource($resourceId, $metadata): Protect a resource
 * - checkIntegrity($resourceId, $currentState): Verify resource hasn't been damaged
 * - preventDestruction($operation, $resourceId): Block destructive operations
 * - getSystemHealth(): Report overall system health
 * 
 * Example:
 * ```
 * $ahimsa->protectResource('database', ['name' => 'Main DB']);
 * $ahimsa->checkIntegrity('database', $currentState);
 * ```
 * 
 * 3.2 ADINNADANA (ไม่ลัก) - Manage Ownership
 * -------------------------------------------
 * 
 * Purpose: Track ownership, manage access control, and prevent theft/misappropriation
 * 
 * Key Functions:
 * - registerOwnership($itemId, $ownerId, $metadata): Register an item's owner
 * - verifyAccess($itemId, $requesterId, $action): Check if access is permitted
 * - grantPermission($itemId, $grantorId, $recipientId, $permissions): Grant permissions
 * - checkPlagiarism($content, $sourceContent): Detect plagiarism
 * 
 * Example:
 * ```
 * $adinnadana->registerOwnership('api_key', 'user_1');
 * if ($adinnadana->verifyAccess('api_key', 'user_1')) {
 *     // Allow access
 * }
 * ```
 * 
 * 3.3 KAMESU (ไม่ละเมิด) - Enforce Consent
 * ------------------------------------------
 * 
 * Purpose: Ensure consent is obtained and respect is maintained
 * 
 * Key Functions:
 * - validateConsent($resource, $actor, $action): Verify consent given
 * - trackViolations($actor, $target): Monitor access violations
 * - reportAbuse($incident): Report abuse incidents
 * 
 * 3.4 MUSAVADA (ไม่พูดเท็จ) - Ensure Truthfulness
 * ------------------------------------------------
 * 
 * Purpose: Ensure data integrity and prevent falsification
 * 
 * Key Functions:
 * - recordTruth($data): Record data with verification
 * - verifyTruth($claim, $evidence): Verify claims against evidence
 * - auditTrail($event): Create audit trail
 * 
 * 3.5 SATI (มีสติ) - Maintain Mindfulness
 * ----------------------------------------
 * 
 * Purpose: Monitor system awareness and catch errors early
 * 
 * Key Functions:
 * - checkMindfulness(): Verify system awareness
 * - monitorFunction($function, $args): Track function performance
 * - systemStatus(): Report system status
 * 
 * ================================================================================
 * 4. USAGE EXAMPLES
 * ================================================================================
 * 
 * 4.1 Basic Setup
 * ----------------
 * 
 * ```php
 * use System\Core\FivePreceptsManager;
 * 
 * // Initialize the manager
 * $preceptManager = new FivePreceptsManager([
 *     'strict_mode' => true,
 *     'enable_cross_check' => true
 * ]);
 * 
 * // Get individual precepts
 * $ahimsa = $preceptManager->getPrecept('ahimsa');
 * $adinnadana = $preceptManager->getPrecept('adinnadana');
 * ```
 * 
 * 4.2 Protecting Resources
 * --------------------------
 * 
 * ```php
 * // Protect a resource
 * $ahimsa->protectResource('user_table', [
 *     'name' => 'Users Table',
 *     'value' => 10000
 * ]);
 * 
 * // Check integrity
 * $result = $ahimsa->checkIntegrity('user_table', $currentData);
 * if (!$result['integrity']) {
 *     throw new PreceptViolationException('Resource corrupted');
 * }
 * ```
 * 
 * 4.3 Managing Ownership and Access
 * -----------------------------------
 * 
 * ```php
 * // Register ownership
 * $adinnadana->registerOwnership('document_123', 'user_1');
 * 
 * // Verify access
 * if ($adinnadana->verifyAccess('document_123', 'user_2')) {
 *     // User can access
 * } else {
 *     // Access denied
 * }
 * 
 * // Grant permission
 * $adinnadana->grantPermission('document_123', 'user_1', 'user_2', ['read']);
 * 
 * // Check if permission exists
 * if ($adinnadana->hasPermission('document_123', 'user_2', 'read')) {
 *     // Allow reading
 * }
 * ```
 * 
 * 4.4 Cross-Precept Validation
 * -----------------------------
 * 
 * ```php
 * // Validate action against all precepts
 * $action = [
 *     'actor' => 'user_1',
 *     'action' => 'delete_data',
 *     'target' => 'users_table'
 * ];
 * 
 * $results = $preceptManager->validateAction($action);
 * 
 * if (!$results['valid']) {
 *     foreach ($results['violations'] as $violation) {
 *         echo "Precept: " . $violation['precept_name'] . "\n";
 *         echo "Message: " . $violation['message'] . "\n";
 *     }
 * }
 * ```
 * 
 * ================================================================================
 * 5. INTEGRATION WITH FRAMEWORK
 * ================================================================================
 * 
 * 5.1 In Controllers
 * --------------------
 * 
 * ```php
 * use System\Core\DharmaLayers\PanyaController;
 * use System\Core\FivePreceptsManager;
 * 
 * class UserController extends PanyaController
 * {
 *     protected $preceptManager;
 *     
 *     public function __construct()
 *     {
 *         parent::__construct();
 *         $this->preceptManager = new FivePreceptsManager();
 *     }
 *     
 *     public function deleteUser($userId)
 *     {
 *         // Validate action
 *         $results = $this->preceptManager->validateAction([
 *             'actor' => auth()->id(),
 *             'action' => 'delete_user',
 *             'target' => $userId
 *         ]);
 *         
 *         if (!$results['valid']) {
 *             return $this->respondWithError('Action violates precepts');
 *         }
 *         
 *         // Proceed with deletion
 *         User::destroy($userId);
 *         return $this->respondWithSuccess('User deleted');
 *     }
 * }
 * ```
 * 
 * 5.2 In Models
 * ---------------
 * 
 * ```php
 * use System\Core\DharmaLayers\AnattaModel;
 * 
 * class User extends AnattaModel
 * {
 *     public function save()
 *     {
 *         // Validate with Musavada (truthfulness)
 *         $validator = new DharmaValidator($this->attributes);
 *         if (!$validator->validate()) {
 *             throw new CompassionateException('Data not truthful');
 *         }
 *         
 *         return parent::save();
 *     }
 * }
 * ```
 * 
 * ================================================================================
 * 6. BEST PRACTICES
 * ================================================================================
 * 
 * 1. Always initialize FivePreceptsManager at application startup
 * 2. Use strict_mode=true in production
 * 3. Log all violations for audit purposes
 * 4. Link precepts to enable cross-validation
 * 5. Check system health regularly
 * 6. Respect ownership and permissions
 * 7. Use compassionate error messages
 * 8. Monitor compliance reports
 * 
 * ================================================================================
 * 7. API REFERENCE
 * ================================================================================
 * 
 * BasePrecept Methods:
 * - validate($data): bool
 * - linkPrecept(BasePrecept $precept): self
 * - getInfo(): array
 * - getStatus(): array
 * - getViolations(): array
 * - getBlessings(): array
 * - export(): array
 * 
 * FivePreceptsManager Methods:
 * - getPrecept($id): BasePrecept
 * - getAllPrecepts(): array
 * - validateAction($action): array
 * - getHealthReport(): array
 * - getComplianceReport(): array
 * - export(): array
 * 
 * ================================================================================
 */
class FivePreceptsDocumentation
{
    // This is a documentation file - no implementation needed
}
