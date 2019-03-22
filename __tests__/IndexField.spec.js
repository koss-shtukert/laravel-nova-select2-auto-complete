import {mount, shallowMount, createLocalVue} from '@vue/test-utils'
import PortalVue from 'portal-vue'
import IndexField from '../resources/js/components/IndexField'

const localVue = createLocalVue()
localVue.use(PortalVue)

describe('IndexField', () => {
    test('it renders correctly without field.value', () => {
        const wrapper = mount(IndexField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    value: null
                }
            },
        })

        expect(wrapper).toMatchSnapshot()
    })

    test('it renders correctly with field.value + options', () => {
        const wrapper = mount(IndexField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    value: 3,
                    options: [
                        {id: 1, text: 'One'},
                        {id: 2, text: 'Two'},
                        {id: 3, text: 'Three'}
                    ]
                }
            }
        })

        expect(wrapper).toMatchSnapshot()
    })

    test('it renders correctly with field.value + options + showAsLink', () => {
        const wrapper = mount(IndexField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    value: 3,
                    options: [
                        {id: 1, text: 'One'},
                        {id: 2, text: 'Two'},
                        {id: 3, text: 'Three'}
                    ],
                    showAsLink: true
                }
            },
            stubs: ['router-link', 'router-view']
        })

        expect(wrapper).toMatchSnapshot()
    })
})
