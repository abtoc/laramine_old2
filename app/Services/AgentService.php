<?

namespace App\Services;

class AgentService
{
    /**
     * @return bool
     */
    function isMobile(): bool
    {
        $userAgent = request()->header('User-Agent');
        return preg_match('/iPhone|iPod|Android/', $userAgent);
    }

    /**
     * @return bool
     */
    function isDesktop(): bool
    {
        return !$this->isMobile();
    }
}
