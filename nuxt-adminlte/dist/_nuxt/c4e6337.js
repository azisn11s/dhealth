(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{218:function(t,e,r){"use strict";r.r(e);var n=r(6),o=(r(35),r(43)),l={layout:"guest",head:{bodyAttrs:{class:"hold-transition register-page",style:""}},data:function(){return{register:new o.Form({firstname:"",lastname:"",email:"",password:"",password_confirmation:""})}},methods:{userRegister:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){var r;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.prev=0,e.next=3,t.$axios.post("/register",t.register);case 3:r=e.sent,t.$auth.setUserToken(r.data.access_token).then((function(){t.$toast.success("Successfully registered.",{icon:"check",iconPack:"fontawesome",duration:5e3,theme:"outline",position:"top-center",action:{text:"Close",onClick:function(t,e){e.goAway(0)}}}),t.$router.push({path:"/"})})),e.next=11;break;case 7:e.prev=7,e.t0=e.catch(0),e.t0.response&&422==e.t0.response.status&&t.$nextTick((function(){t.register.errors.set(e.t0.response.data.errors)})),t.$toast.error("Unauthenticated.",{icon:"exclamation-triangle",iconPack:"fontawesome",duration:5e3});case 11:case"end":return e.stop()}}),e,null,[[0,7]])})))()}}},c=r(8),component=Object(c.a)(l,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"register-box"},[r("div",{staticClass:"card card-outline card-primary"},[t._m(0),t._v(" "),r("div",{staticClass:"card-body"},[r("p",{staticClass:"login-box-msg"},[t._v("Register a new membership")]),t._v(" "),r("form",{on:{submit:function(e){return e.preventDefault(),t.userRegister(e)}}},[r("div",{staticClass:"input-group mb-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.register.firstname,expression:"register.firstname"}],staticClass:"form-control",class:{"is-invalid":t.register.errors.has("firstname")},attrs:{type:"text",placeholder:"Fist name"},domProps:{value:t.register.firstname},on:{input:function(e){e.target.composing||t.$set(t.register,"firstname",e.target.value)}}}),t._v(" "),t._m(1),t._v(" "),r("has-error",{attrs:{form:t.register,field:"firstname"}})],1),t._v(" "),r("div",{staticClass:"input-group mb-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.register.lastname,expression:"register.lastname"}],staticClass:"form-control",class:{"is-invalid":t.register.errors.has("lastname")},attrs:{type:"text",placeholder:"Last name"},domProps:{value:t.register.lastname},on:{input:function(e){e.target.composing||t.$set(t.register,"lastname",e.target.value)}}}),t._v(" "),t._m(2),t._v(" "),r("has-error",{attrs:{form:t.register,field:"lastname"}})],1),t._v(" "),r("div",{staticClass:"input-group mb-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.register.email,expression:"register.email"}],staticClass:"form-control",class:{"is-invalid":t.register.errors.has("email")},attrs:{type:"email",placeholder:"Email"},domProps:{value:t.register.email},on:{input:function(e){e.target.composing||t.$set(t.register,"email",e.target.value)}}}),t._v(" "),t._m(3),t._v(" "),r("has-error",{attrs:{form:t.register,field:"email"}})],1),t._v(" "),r("div",{staticClass:"input-group mb-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.register.password,expression:"register.password"}],staticClass:"form-control",class:{"is-invalid":t.register.errors.has("password")},attrs:{type:"password",placeholder:"Password"},domProps:{value:t.register.password},on:{input:function(e){e.target.composing||t.$set(t.register,"password",e.target.value)}}}),t._v(" "),t._m(4),t._v(" "),r("has-error",{attrs:{form:t.register,field:"password"}})],1),t._v(" "),r("div",{staticClass:"input-group mb-3"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.register.password_confirmation,expression:"register.password_confirmation"}],staticClass:"form-control",attrs:{type:"password",placeholder:"Retype password"},domProps:{value:t.register.password_confirmation},on:{input:function(e){e.target.composing||t.$set(t.register,"password_confirmation",e.target.value)}}}),t._v(" "),t._m(5)]),t._v(" "),t._m(6)]),t._v(" "),r("div",{staticClass:"social-auth-links text-center"}),t._v(" "),r("router-link",{staticClass:"text-center",attrs:{to:"/login"}},[t._v("I already have a membership")])],1)])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"card-header text-center"},[r("a",{staticClass:"h1",attrs:{href:"../../index2.html"}},[r("b",[t._v("Admin")]),t._v("LTE")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-append"},[e("div",{staticClass:"input-group-text"},[e("span",{staticClass:"fas fa-user"})])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-append"},[e("div",{staticClass:"input-group-text"},[e("span",{staticClass:"fas fa-user"})])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-append"},[e("div",{staticClass:"input-group-text"},[e("span",{staticClass:"fas fa-envelope"})])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-append"},[e("div",{staticClass:"input-group-text"},[e("span",{staticClass:"fas fa-lock"})])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"input-group-append"},[e("div",{staticClass:"input-group-text"},[e("span",{staticClass:"fas fa-lock"})])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("div",{staticClass:"col-8"}),t._v(" "),r("div",{staticClass:"col-4"},[r("button",{staticClass:"btn btn-primary btn-block",attrs:{type:"submit"}},[t._v("\n\t\t\t\t\t\t\tRegister\n\t\t\t\t\t\t")])])])}],!1,null,null,null);e.default=component.exports}}]);