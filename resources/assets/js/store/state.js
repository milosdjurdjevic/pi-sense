/* eslint-disable */
import localStorage from 'store';

export default {
  user: localStorage.get('user') || {},
  token: localStorage.get('token') || '',
}
