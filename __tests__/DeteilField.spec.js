import {mount, shallowMount, createLocalVue} from '@vue/test-utils'
import PortalVue from 'portal-vue'
import DetailField from '../resources/js/components/DetailField'

const localVue = createLocalVue()
localVue.use(PortalVue)

// shallowMount(DetailField, {
//     stubs: ['router-link', 'router-view']
// })

describe('DetailField', () => {
    test('it renders correctly without field.value', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
                    value: null
                }
            }
        })

        expect(wrapper).toMatchSnapshot()
    })

    test('it field.value is null', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
                    value: null
                }
            }
        })

        expect(wrapper.props().field.value).toBe(null)
    })

    test('it field name is Parent category', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
                    value: null
                }
            }
        })

        expect(wrapper.text()).toContain('Parent category')
    })

    test('it renders correctly with field.value + options', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
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

    test('it field.value is 3', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
                    value: 3,
                    options: [
                        {id: 1, text: 'One'},
                        {id: 2, text: 'Two'},
                        {id: 3, text: 'Three'}
                    ]
                }
            }
        })

        expect(wrapper.props().field.value).toBe(3)
    })

    test('it renders correctly with field.value + options + showAsLink', () => {
        const wrapper = mount(DetailField, {
            localVue,
            propsData: {
                resourceName: 'category',
                field: {
                    name: 'Parent category',
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
