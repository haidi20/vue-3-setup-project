import { useStore } from 'vuex'
import { ref, computed, watch, onMounted, onUpdated, onUnmounted } from 'vue'
import { useState, useActions, useMutations, useGetters } from '@/utils/helpers/store_helper'

export default function useUser() {
  const users = ref([]);
  const error = ref(null);

  const { authLogin, fetchGroupNames } = useActions('auth', {
    authLogin: 'onLogin',
    fetchGroupNames: 'fetchGroupNames',
  });

  const { groups } = useState('dashboard', {
    groups: 'data.groups',
  });

  async function loginAndGetSession() {
    const response = await fetchLogin();

    const result = await response.json();

    // console.log('Login result:', result);

    if (!result.result.uid) {
      throw new Error('Login failed or no UID found');
    }

    return true;
  }

  async function fetchUsers() {
    let allFields = [
      'id',
      'name',
      'login',
      'email',
      'active',
      'groups_id',
      'partner_id',
      'company_id',
      'create_date',
      'last_login'
    ];

    try {
      const fieldsResponse = await fetch('/web/dataset/call_kw', {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          jsonrpc: '2.0',
          method: 'call',
          params: {
            model: 'res.users',
            method: 'fields_get',
            args: [],
            kwargs: {}
          }
        })
      });

      const fieldsResult = await fieldsResponse.json();

      if (fieldsResult.result) {
        allFields = Object.keys(fieldsResult.result);
      } else {
        console.warn('Gagal ambil semua field, gunakan field default');
      }

    } catch (fieldError) {
      console.error('Error fetching fields, fallback to default:', fieldError);
    }

    // Ambil data pengguna dengan field yang tersedia
    try {
      const response = await fetch('/web/dataset/call_kw', {
        method: 'POST',
        credentials: 'include',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          jsonrpc: '2.0',
          method: 'call',
          params: {
            model: 'res.users',
            method: 'search_read',
            args: [],
            kwargs: {
              domain: [],
              fields: allFields
            },
          },
        }),
      });

      const result = await response.json();

      console.log('fetchUsers result:', result);

      const fetchedUsers = result.result || [];

      users.value = fetchedUsers;

    } catch (fetchError) {
      throw new Error('Gagal ambil data pengguna: ' + fetchError.message);
    }
  }

  async function combineUsersAndGroup() {
    const groupIdSet = new Set();
    users.value.forEach(user => {
      if (Array.isArray(user.groups_id)) {
        user.groups_id.forEach(id => groupIdSet.add(id));
      }
    });
    const groupIds = Array.from(groupIdSet);

    await fetchGroupNames(groupIds).then(response => {

      const groupList = response.data || [];

      groupList.map(group => (
        {
          id: group.id,
          name: group.name,
        }
      ));

      users.value = users.value.map(user => {
        if (Array.isArray(user.groups_id)) {
          user.groups = groupList.filter(group => user.groups_id.includes(group.id));
        } else {
          user.group_names = [];
        }
        return user;
      });

      console.log('Combined users with groups:', users.value);
    });
  }

  onMounted(async () => {
    try {
      await authLogin();
      await fetchUsers();

      combineUsersAndGroup();
    } catch (err) {
      error.value = err.message
      console.error('Error fetching users:', err)
    }
  })

  return {
    users,
    error,
    fetchUsers,
    loginAndGetSession,
  }
}