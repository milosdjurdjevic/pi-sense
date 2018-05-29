/* eslint-disable */
import localStorage from 'store';
import state from 'index';

export default {
    user: localStorage.get('user') || {},
    token: localStorage.get('token') || '',
    state: state
}
