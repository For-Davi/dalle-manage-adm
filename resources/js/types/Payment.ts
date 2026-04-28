export interface EnterprisePayment {
    id: number;
    status: string;
    enterprise_name: string;
    enterprise_email: string;
    payment_type: string;
    subscription: string;
    month_qnty: string;
    created_at: string;
};

export interface FilterEnterprisePayment {
    startDate: string;
    endDate: string;
    enterprise: string;
    status: string | null;
}