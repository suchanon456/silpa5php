# Silpa5PHP Framework - Five Precepts System

## 📖 Overview

The **Five Precepts System** is the ethical and security foundation of Silpa5PHP Framework. It implements Buddhist principles (Panca Sila) to ensure the framework operates with integrity, mindfulness, and compassion.

```
ศีล 5 ประการ (Five Precepts)
├── 1. Ahimsa (ไม่ทำลาย)         - Protect & don't harm
├── 2. Adinnadana (ไม่ลัก)       - Respect ownership
├── 3. Kamesu (ไม่ละเมิด)        - Enforce consent
├── 4. Musavada (ไม่พูดเท็จ)     - Ensure truthfulness
└── 5. Sati (มีสติ)              - Maintain mindfulness
```

## 🏗️ System Architecture

```
FivePreceptsManager (Orchestrator)
    ├── BasePrecept (Abstract Base)
    │   ├── AhimsaPrecept
    │   ├── Adinnadana
    │   ├── Kamesu
    │   ├── Musavada
    │   └── Sati
    ├── Exception System
    │   ├── PreceptViolationException
    │   ├── KarmaException
    │   └── CompassionateException
    └── Support Classes
        ├── PreceptHelper
        ├── KarmaHelper
        └── DharmaHelper
```

## 🔧 Core Components

### 1. BasePrecept (Base Class)

**Location**: `system/Core/BasePrecept.php`

Provides common functionality for all precepts:
- Violation and blessing logging
- Precept linking for cross-validation
- Status and compliance reporting
- Data export

```php
use System\Core\BasePrecept;

// All precepts extend BasePrecept
class CustomPrecept extends BasePrecept {
    public function validate($data) {
        // Implement precept-specific validation
        return true;
    }
}
```

### 2. Individual Precepts

#### Ahimsa (ไม่ทำลาย) - Prevent Harm
**Location**: `system/Core/FivePrecepts/AhimsaPrecept.php`

Protects system resources from destruction:
```php
$ahimsa = $preceptManager->getPrecept('ahimsa');

// Protect resources
$ahimsa->protectResource('database', ['name' => 'Main DB']);

// Check integrity
$result = $ahimsa->checkIntegrity('database', $currentState);

// Prevent destructive operations
$ahimsa->preventDestruction('drop_table', 'users');
```

#### Adinnadana (ไม่ลัก) - Manage Ownership
**Location**: `system/Core/FivePrecepts/Adinnadana.php`

Manages ownership, access control, and plagiarism detection:
```php
$adinnadana = $preceptManager->getPrecept('adinnadana');

// Register ownership
$adinnadana->registerOwnership('api_key', 'user_1', ['service' => 'payment']);

// Verify access
$adinnadana->verifyAccess('api_key', 'user_1', 'use');

// Grant permissions
$adinnadana->grantPermission('document', 'user_1', 'user_2', ['read']);

// Check for plagiarism
$report = $adinnadana->checkPlagiarism($content, $sourceContent);
```

#### Kamesu (ไม่ละเมิด) - Enforce Consent
**Location**: `system/Core/FivePrecepts/Kamesu.php`

Ensures consent and respects rights:
```php
$kamesu = $preceptManager->getPrecept('kamesu');

// Validate consent before action
$kamesu->validateAccess($userId, $targetUserId, $resource);

// Protect personal data
$kamesu->protectPersonalData($data, ['name', 'email']);
```

#### Musavada (ไม่พูดเท็จ) - Ensure Truthfulness
**Location**: `system/Core/FivePrecepts/Musavada.php`

Ensures data integrity and prevents falsification:
```php
$musavada = $preceptManager->getPrecept('musavada');

// Validate truthfulness
$musavada->validateTruth($data);

// Log actions truthfully
$musavada->logAction($action, $actor, $target, $result);

// Detect lies/inconsistencies
$musavada->detectLies($claimed, $actual);
```

#### Sati (มีสติ) - Maintain Mindfulness
**Location**: `system/Core/FivePrecepts/Sati.php`

Monitors system awareness and performance:
```php
$sati = $preceptManager->getPrecept('sati');

// Check system mindfulness
$sati->checkMindfulness();

// Monitor function execution
$result = $sati->monitorFunction($callback, $args);

// Log with mindfulness
$sati->logWithMindfulness($action, $details);
```

### 3. FivePreceptsManager

**Location**: `system/Core/FivePreceptsManager.php`

Orchestrates all precepts and provides system-wide validation:

```php
use System\Core\FivePreceptsManager;

$manager = new FivePreceptsManager([
    'strict_mode' => true,
    'enable_cross_check' => true,
    'log_events' => true
]);

// Get specific precept
$ahimsa = $manager->getPrecept('ahimsa');

// Validate action against all precepts
$results = $manager->validateAction([
    'actor' => 'user_1',
    'action' => 'delete_data',
    'target' => 'users_table'
]);

// Get health report
$health = $manager->getHealthReport();

// Get compliance report
$compliance = $manager->getComplianceReport();

// Export all data
$export = $manager->export();
```

## 📋 Exception System

### PreceptViolationException
Thrown when a precept is violated:
```php
try {
    $adinnadana->verifyAccess('api_key', 'unauthorized_user');
} catch (PreceptViolationException $e) {
    echo $e->getMessage();
    echo $e->getPrecept();
    echo $e->getDetails();
}
```

### KarmaException
Tracks consequences of actions:
```php
throw new KarmaException('deletion', 'negative', 'Data was permanently deleted');
```

### CompassionateException
Provides helpful, empathetic error messages:
```php
throw new CompassionateException(
    'database_connection',
    'Check your connection credentials'
);
```

## 🔗 Cross-Precept Integration

Precepts are linked for automatic cross-validation:

```php
// When checking one precept, others are checked automatically
$results = $ahimsa->crossCheckWithLinked($data);

// Results:
[
    'primary' => true/false,
    'linked' => [
        'adinnadana' => ['status' => true/false],
        'kamesu' => ['status' => true/false],
        // ... other precepts
    ]
]
```

## 📊 Reporting and Compliance

### Health Report
```php
$health = $manager->getHealthReport();
// Returns: status, precept violations, system health metrics
```

### Compliance Report
```php
$compliance = $manager->getComplianceReport();
// Returns: total violations, blessings, compliance percentage
```

### Precept Status
```php
$status = $precept->getStatus();
// Returns: precept info, violation/blessing counts, adherence rate
```

## 💾 Helper Classes

### PreceptHelper
```php
use System\Helpers\PreceptHelper;

// Check if precept is followed
PreceptHelper::checkPrecept(PreceptHelper::AHIMSA, $data);

// Get precept violation
PreceptHelper::checkViolation(PreceptHelper::AHIMSA, $data);

// Get precept suggestions
PreceptHelper::suggestPreceptPractice(PreceptHelper::AHIMSA);
```

### KarmaHelper
```php
use System\Helpers\KarmaHelper;

// Record action and calculate karma
KarmaHelper::recordAction('user_1', 'create_post', 'posts_table', true);

// Calculate karma score
$score = KarmaHelper::calculateKarmaScore('user_1');

// Get karma statistics
$stats = KarmaHelper::getKarmaStats();
```

### DharmaHelper
```php
use System\Helpers\DharmaHelper;

// Check if action is dharmic
DharmaHelper::isDharmic('help_user');

// Get dharmic value
$value = DharmaHelper::getDharmicValue('teach');

// Get suggestions
DharmaHelper::suggestDharmic('conflict');
```

## 🚀 Usage Examples

### Basic Setup
```php
use System\Core\FivePreceptsManager;

// Initialize in your application bootstrap
$preceptManager = new FivePreceptsManager();
```

### In Controllers
```php
class UserController extends PanyaController {
    protected $preceptManager;
    
    public function deleteUser($userId) {
        $results = $this->preceptManager->validateAction([
            'actor' => auth()->id(),
            'action' => 'delete_user',
            'target' => $userId
        ]);
        
        if (!$results['valid']) {
            return $this->respondWithError('Action violates precepts');
        }
        
        User::destroy($userId);
        return $this->respondWithSuccess('User deleted');
    }
}
```

### With Validation
```php
use System\Validation\DharmaValidator;
use System\Validation\Rules\TruthRule;
use System\Validation\Rules\CompassionRule;

$validator = new DharmaValidator($data, [
    'name' => 'required|truth',
    'message' => 'required|compassion'
]);

if ($validator->validate()) {
    // Data is truthful and compassionate
}
```

## 📚 File Structure

```
system/Core/
├── BasePrecept.php                  # Abstract base class
├── FivePreceptsManager.php          # Orchestrator
├── FivePrecepts/
│   ├── AhimsaPrecept.php            # No harm
│   ├── Adinnadana.php               # No stealing
│   ├── Kamesu.php                   # No abuse
│   ├── Musavada.php                 # No lying
│   └── Sati.php                     # Mindfulness
├── Exceptions/
│   ├── PreceptViolationException.php
│   ├── KarmaException.php
│   └── CompassionateException.php
└── ...

system/Helpers/
├── PreceptHelper.php                # Precept utilities
├── KarmaHelper.php                  # Karma tracking
└── DharmaHelper.php                 # Dharma utilities

system/Documentation/
└── FivePreceptsDocumentation.php    # Full documentation

system/Examples/
└── FivePreceptsExample.php          # Usage examples
```

## ⚙️ Configuration

```php
$manager = new FivePreceptsManager([
    'strict_mode' => true,           // Throw exceptions on violations
    'enable_cross_check' => true,    // Validate across precepts
    'log_events' => true,            // Log all events
    'log_path' => __DIR__ . '/logs/'
]);
```

## 🎯 Best Practices

1. ✅ Always initialize FivePreceptsManager at startup
2. ✅ Use strict_mode=true in production
3. ✅ Link precepts for comprehensive validation
4. ✅ Log violations for audit trails
5. ✅ Check health reports regularly
6. ✅ Respect ownership and permissions
7. ✅ Use compassionate error messages
8. ✅ Monitor compliance metrics

## 📝 License

MIT License - See LICENSE file for details

## 🙏 Inspired By

- Buddhist Five Precepts (Panca Sila)
- Ethical Computing Principles
- Security Best Practices
- Compassionate Software Design

---

**Silpa5PHP Framework** - Build with Virtue (ศรีพยั คุณธรรม)
