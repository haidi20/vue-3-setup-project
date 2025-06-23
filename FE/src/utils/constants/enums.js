const StatusEnum = Object.freeze({
    PENDING: "PENDING",
    VERIFIED: "VERIFIED",
    NEED_ACTIVATION: "NEED_ACTIVATION",
    REJECTED: "REJECTED",
    DRAFT: "DRAFT",
    PUBLISHED: "PUBLISHED",
    CLOSED: "CLOSED",
    APPLIED: "APPLIED",
    INVITED: "INVITED",
    APPROVED: "APPROVED",
    CALLED: "CALLED",
    PASSED: "PASSED",
    ACCEPTED: "ACCEPTED",
    HIRED: "HIRED",
    NOT_YET_VERIFIED: "NOT_YET_VERIFIED",
});

const StatusResponseEnum = Object.freeze({
    SUCCESS: 'success',
    FAIL: 'fail',
    ERROR: 'error',
    UNAUTHORIZED: 'unauthorized',
});

export {
    StatusEnum,
    StatusResponseEnum,
};
