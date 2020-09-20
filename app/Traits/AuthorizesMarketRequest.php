<?php

namespace App\Traits;

class AuthorizesMarketRequest
{
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers['Authorization'] = $accessToken;
    }

    public function resolveAccessToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFiMTI1ZjMxMDUwZGM1MGIwNDcxY2E0NjZlNjVkN
        DFhY2M4NDg5ZTM5ZTg3MzNhMDhiY2JiNmEyNGViZTg2ZjkzYmQxYzhkZmE5YjZmNWQ5In0.eyJhdWQiOiIyIiwianRpIjoiYWIxM
        jVmMzEwNTBkYzUwYjA0NzFjYTQ2NmU2NWQ0MWFjYzg0ODllMzllODczM2EwOGJjYmI2YTI0ZWJlODZmOTNiZDFjOGRmYTliNmY1Z
        DkiLCJpYXQiOjE2MDA1Njg2MDYsIm5iZiI6MTYwMDU2ODYwNiwiZXhwIjoxNjMyMTA0NjA2LCJzdWIiOiIxMzkwIiwic2NvcGVzI
        jpbInB1cmNoYXNlLXByb2R1Y3QiLCJtYW5hZ2UtcHJvZHVjdHMiLCJtYW5hZ2UtYWNjb3VudCIsInJlYWQtZ2VuZXJhbCJdfQ.Al
        tlJ5KcnDS0NlCwC16Pddiw1Bzo2Q3ibo8H6KCWL5YDELfarwWActSEJGTYemFkml3ifpWwVYFGvP2PrKvG9yzMHVZYNGEQkMfcLg
        44pLbRyt5iX9q_PzjNiVWqCPDmf_Deb4o7Hvhfj7ZFw5J1S4en0zWuRVsKZy87WWl-0Uy80qCNS8TofvPbM43-QMDC8Lz__OcbAU
        Usj_BPvM4sIrHzW-UDveuEBmRKIxhlpQBxHH2SfcRalxNqi9TmJShdKGPkpxFRtlGY9zNxDSINHh-TIIDGkCs9YZlkxm_WupSdrD
        ugYb_S45IwIBubRPgVH3QQnsbxF5BTFz1bDmo0ZaIv1pSVuhTsl-b39cjW-1z4keiJC0Io62sutbdgmR1mMjFuFUk1nHcsP2BzR8
        BcpYiYrLdGVy8p6w_ILeiazlVP9iW-wr5dhIZlAykI_mpSgwxdXzkpOTywsqXplQPqqX77A9-_1zja-Mxb_gNGiiXrgyT0MzFrip
        smG7RJI6T5T7Fzm88cuoqqb0pX-dKX5eIBd366kwU-sM013HAhRkKSWdzUHoSQmYv_5Nw4VAU7C_H3i2X3uT12zB6SuNcRoiwgKr
        karj1P9R7BwRQRTe68GcKrYQ9ppQ3wfEgotLxm6GFG_Zo2VP_jOeLC1JGUlNKqaab47uvKREbV_pSDmYQ';
    }
}
